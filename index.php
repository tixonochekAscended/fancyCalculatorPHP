<?php
session_start();
if (!isset($_SESSION['curValue'])) {
    $_SESSION['curValue'] = "0";
}
$_SESSION['footer'] = "";

if (isset($_GET['clear'])) {
    $_SESSION['curValue'] = "0";
}

if (isset($_GET['digit'])) {
    if ($_SESSION['curValue'] == "0") {
        $_SESSION['curValue'] = $_GET['digit'];
    } else {
        $_SESSION['curValue'] = $_SESSION['curValue'] . $_GET['digit'];
    }
}

if (isset($_GET['comma'])) {
    if (str_contains($_SESSION['curValue'], "A")) {
        $parts = explode("A", $_SESSION['curValue']);
        if (str_ends_with($parts[1], ".")) {
            $parts[1] = substr($parts[1], 0, strlen($parts[1])-1);
        } else {
            if (!str_contains($parts[1], '.')) {
                $parts[1] = $parts[1] . ".";
            }
        }
        $_SESSION['curValue'] = $parts[0] . "A" . $parts[1];
    } else if (str_contains($_SESSION['curValue'], "M")) {
        $parts = explode("M", $_SESSION['curValue']);
        if (str_ends_with($parts[1], ".")) {
            $parts[1] = substr($parts[1], 0, strlen($parts[1])-1);
        } else {
            if (!str_contains($parts[1], '.')) {
                $parts[1] = $parts[1] . ".";
            }
        }
        $_SESSION['curValue'] = $parts[0] . "M" . $parts[1];
    } else if (str_contains($_SESSION['curValue'], "L")) {
        $parts = explode("L", $_SESSION['curValue']);
        if (str_ends_with($parts[1], ".")) {
            $parts[1] = substr($parts[1], 0, strlen($parts[1])-1);
        } else {
            if (!str_contains($parts[1], '.')) {
                $parts[1] = $parts[1] . ".";
            }
        }
        $_SESSION['curValue'] = $parts[0] . "L" . $parts[1];
    } else if (str_contains($_SESSION['curValue'], "D")) {
        $parts = explode("D", $_SESSION['curValue']);
        if (str_ends_with($parts[1], ".")) {
            $parts[1] = substr($parts[1], 0, strlen($parts[1])-1);
        } else {
            if (!str_contains($parts[1], '.')) {
                $parts[1] = $parts[1] . ".";
            }
        }
        $_SESSION['curValue'] = $parts[0] . "D" . $parts[1];
    } else {
        if (str_ends_with($_SESSION['curValue'], ".")) {
            $_SESSION['curValue'] = substr($_SESSION['curValue'], 0, strlen($_SESSION['curValue'])-1);
        } else {
            if (!str_contains($_SESSION['curValue'], '.')) {
                $_SESSION['curValue'] = $_SESSION['curValue'] . ".";
            }
        }
    }
}

if (isset($_GET['operation'])) {
    if (str_ends_with($_SESSION['curValue'], ".")) {
        $_SESSION['curValue'] = substr($_SESSION['curValue'], 0, strlen($_SESSION['curValue'])-1);
    }
    if (str_ends_with($_SESSION['curValue'], "A") || str_ends_with($_SESSION['curValue'], "M")
    || str_ends_with($_SESSION['curValue'], "L") || str_ends_with($_SESSION['curValue'], "D")) {
        switch ($_GET['operation']) {
            case 'add':
                $_SESSION['curValue'] = substr($_SESSION['curValue'], 0, strlen($_SESSION['curValue'])-1) . "A";
                break;
            case 'min':
                $_SESSION['curValue'] = substr($_SESSION['curValue'], 0, strlen($_SESSION['curValue'])-1) . "M";
                break;
            case 'mul':
                $_SESSION['curValue'] = substr($_SESSION['curValue'], 0, strlen($_SESSION['curValue'])-1) . "L";
                break;
            case 'div':
                $_SESSION['curValue'] = substr($_SESSION['curValue'], 0, strlen($_SESSION['curValue'])-1) . "D";
                break;
        }
    } else {
        if (!(str_contains($_SESSION['curValue'], "A") || str_contains($_SESSION['curValue'], "M")
        || str_contains($_SESSION['curValue'], "L") || str_contains($_SESSION['curValue'], "D"))) {
            switch ($_GET['operation']) {
                case 'add':
                    $_SESSION['curValue'] = $_SESSION['curValue'] . "A";
                    break;
                case 'min':
                    $_SESSION['curValue'] = $_SESSION['curValue'] . "M";
                    break;
                case 'mul':
                    $_SESSION['curValue'] = $_SESSION['curValue'] . "L";
                    break;
                case 'div':
                    $_SESSION['curValue'] = $_SESSION['curValue'] . "D";
                    break;
            }   
        }
    }
}

if (isset($_GET['equals'])) {
    if (str_ends_with($_SESSION['curValue'], ".")) {
        $_SESSION['curValue'] = substr($_SESSION['curValue'], 0, strlen($_SESSION['curValue'])-1);
    } else if (str_ends_with($_SESSION['curValue'], "A")) {
        //
    } else if (str_ends_with($_SESSION['curValue'], "M")) {
        //
    } else if (str_ends_with($_SESSION['curValue'], "L")) {
        //
    } else if (str_ends_with($_SESSION['curValue'], "D")) {
        //
    } else {
        $otd = null;
        if (str_contains($_SESSION['curValue'], 'A')) {
            $otd = 'A';
        } else if (str_contains($_SESSION['curValue'], 'M')) {
            $otd = 'M';
        } else if (str_contains($_SESSION['curValue'], 'L')) {
            $otd = 'L';
        } else if (str_contains($_SESSION['curValue'], 'D')) {
            $otd = 'D';
        }
        if (!($otd == null)) {
            $parts = explode('|', str_replace(['A','M','L','D'], '|', $_SESSION['curValue']));
            if (floatval($parts[0]) == round(floatval($parts[0]),0)) {
                $parts[0] == intval($parts[0]);
            }
            if (floatval($parts[1]) == round(floatval($parts[1]),0)) {
                $parts[1] == intval($parts[1]);
            }
            switch ($otd) {
                case 'A':
                    $_SESSION['curValue'] = strval($parts[0] + $parts[1]);
                    break;
                case 'M':
                    $_SESSION['curValue'] = strval($parts[0] - $parts[1]);
                    break;
                case 'L':
                    $_SESSION['curValue'] = strval($parts[0] * $parts[1]);
                    break;
                case 'D':
                    if ($parts[1] == 0) {
                        $_SESSION['footer'] = "Error: DIVISION BY ZERO";
                        break;
                    }
                    $_SESSION['curValue'] = strval($parts[0] / $parts[1]);
                    break;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🧮 Calculator Application | 🐘 PHP Learning</title>
    <link rel="shortcut icon" href="icon.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="index.php" method="get">
        <div class="ui">
        <?php
            if (strlen($_SESSION['curValue']) >= 20) {
                echo "<div class=\"redOutput\">❌ Too many digits!</div>";
            } else {
                $final = '';
                foreach (str_split($_SESSION['curValue']) as $char) {
                    switch ($char) {
                        case 'A':
                            $final .= "<div class=\"operation\">add</div>";
                            break;
                        case 'M':
                            $final .= "<div class=\"operation\">substract</div>";
                            break;
                        case 'L':
                            $final .= "<div class=\"operation\">multiply by</div>";
                            break;
                        case 'D':
                            $final .= "<div class=\"operation\">divide by</div>";
                            break;
                        default:
                            $final .= "{$char}";
                            break;
                    }
                }
                echo "<div class=\"output\">{$final}</div>";
            }
        ?>
        <ul>
            <li><button name="clear" value="clr">C</button></li>
            <li><button class="unactive">*</button></li>
            <li><button class="unactive">*</button></li>
            <li><button class="unactive">*</button></li>
        </ul>
        <ul>
            <li><button name="digit" value="7">7</button></li>
            <li><button name="digit" value="4">4</button></li>
            <li><button name="digit" value="1">1</button></li>
            <li><button name="digit" value="0">0</button></li>
        </ul>
        <ul>
            <li><button name="digit" value="8">8</button></li>
            <li><button name="digit" value="5">5</button></li>
            <li><button name="digit" value="2">2</button></li>
            <li><button name="comma" value=".">.</button></li>
        </ul>
        <ul>
            <li><button name="digit" value="9">9</button></li>
            <li><button name="digit" value="6">6</button></li>
            <li><button name="digit" value="3">3</button></li>
            <li><button name="equals" value="="> = </button></li>
        </ul>
        <ul>
            <li><button name="operation" value="div"> ÷ </button></li>
            <li><button name="operation" value="mul"> × </button></li>
            <li><button name="operation" value="min"> - </button></li>
            <li><button name="operation" value="add"> + </button></li>
        </ul>
        </div>
        <?php
        echo "<div class=\"bl\">{$_SESSION['footer']}</div>";
        ?>
    </form>
</body>
</html>