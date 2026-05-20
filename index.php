<?php
define('BASEPATH', realpath(dirname(__FILE__)));
require_once BASEPATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

session_start();

if (!isset($_SESSION['board'])) {
    $gameBoard = new Board();
    $gameBoard->reset();

    $player1 = new Player('Maksym', 'X');
    $player2 = new Player('Olek', 'O');

    $_SESSION['board'] = $gameBoard;
    $_SESSION['players'] = [$player1, $player2];
    $_SESSION['currentPlayerIndex'] = 0;
}
$gameBoard = $_SESSION['board'];
$players = $_SESSION['players'];
$currentPlayerIndex = $_SESSION['currentPlayerIndex'];

foreach ($_GET as $key => $value) {
    if (strpos($key, '-') !== false) {
        $coordinats = explode('-', $key);
        $x = $coordinats[0];
        $y = $coordinats[1];

        $currentPlayer = $players[$currentPlayerIndex];

        try {
            $gameBoard->makeMove($currentPlayer->getToken(), $x, $y);
            if ($currentPlayerIndex === 0) {
                $currentPlayerIndex = 1;
            } else {
                $currentPlayerIndex = 0;
            }
            $_SESSION['board'] = $gameBoard;
            $_SESSION['currentPlayerIndex'] = $currentPlayerIndex;
        } catch (Exception $e) {
        }
    }
}
$currentPlayer = $players[$currentPlayerIndex];
?>

<!doctype html>

<html lang="de">

<head>

    <meta charset="utf-8" />

    <title>
        Tic-Tac-Toe. This is the title. It is displayed in the titlebar of the
        window in most browsers.
    </title>

    <meta
        name="description"
        content="Tic-Tac-Toe-Game. Here is a short description for the page. This text is displayed e. g. in search engine result listings."
    />

    <style>
        table.tic td {
            border: 1px solid #333; /* grey cell borders */
            width: 8rem;
            height: 8rem;
            vertical-align: middle;
            text-align: center;
            font-size: 4rem;
            font-family: Arial;
        }

        table {
            margin-bottom: 2rem;
        }

        input.field {
            border: 0;
            background-color: white;
            color: white; /* make the value invisible (white) */
            height: 8rem;
            width: 8rem !important;
            font-family: Arial;
            font-size: 4rem;
            font-weight: normal;
            cursor: pointer;
        }

        input.field:hover {
            border: 0;
            color: #c81657; /* red on hover */
        }

        .colorX {
            color: #e77;
        } /* X is light red */

        .colorO {
            color: #77e;
        } /* O is light blue */

        table.tic {
            border-collapse: collapse;
        }
    </style>

</head>

<body>

<section>

    <h1>Tic-Tac-Toe</h1>

    <article id="mainContent">

        <h2>Your free browsergame!</h2>

        <p>Type your game instructions here...</p>

        <form method="get" action="index.php">

            <table class="tic">
                <?php foreach ($gameBoard->getBoard() as $x => $row) { ?>
                    <tr>
                        <?php foreach ($row as $y => $cell) { ?>
                            <td>
                                <?php if ($cell === '') { ?>
                                    <input type="submit" class="reset field" name="<?php echo $x; ?>-<?php echo $y; ?>" value="<?php echo $currentPlayer->getToken(); ?>"/>
                                <?php } else { ?>
                                    <span class="color<?php echo strtoupper(
                                        $cell,
                                    ); ?>"><?php echo strtoupper($cell); ?></span>
                                <?php } ?>
                            </td>
                        <?php } ?>
                    </tr>
                <?php } ?>
            </table>

        </form>

    </article>

</section>

</body>

</html>