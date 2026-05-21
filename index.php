<?php
define('BASEPATH', realpath(dirname(__FILE__)));
require_once BASEPATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

session_start();

if (isset($_GET['reset'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

if (!isset($_SESSION['board'])) {
    $gameBoard = new Board();
    $gameBoard->reset();
    $winner = null;
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
            $winner = $gameBoard->checkWiner();
            if ($winner != null) {
                $_SESSION['winner'] = $winner;
                $_SESSION['board'] = $gameBoard;
            } else {
                if ($currentPlayerIndex === 0) {
                    $currentPlayerIndex = 1;
                } else {
                    $currentPlayerIndex = 0;
                }
                $_SESSION['board'] = $gameBoard;
                $_SESSION['currentPlayerIndex'] = $currentPlayerIndex;
            }
        } catch (Exception $e) {
        }
    }
}
$currentPlayer = $players[$currentPlayerIndex];
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Tic-Tac-Toe. This is the title. It is displayed in the titlebar of the window in most browsers.</title>
    <meta name="description" content="Tic-Tac-Toe-Game. Here is a short description for the page. This text is displayed e. g. in search engine result listings.">
    
    <link href="./css/bootstrap.css" rel="stylesheet">
    <link href="./css/add.css" rel="stylesheet"> 
    
    <style>
        .bg-colorESFLGruen { background-color: #00948e; }
        .bg-colorESFLRot { background-color: #c81657; }
        .bg-colorESFLBlau { background-color: #0d80b9; }
        .bg-colorESFLGelb { background-color: #f6d700; }
        .bg-colorESFLGrau { background-color: #3d3d3b; }
        .bg-colorWhite { background-color: white; }
        .textWhite { color: white; }
        .navbar-logo { height: 34px; }
        .footer-logo {
            height: 8rem;
            border: .5rem solid white;
        }
        table.tic td {
            border: 1px solid #333; 
            width: 8rem;
            height: 8rem;
            vertical-align: middle;
            text-align: center;
            font-size: 4rem;
            font-family: Arial;
        }
        table { margin-bottom: 2rem; }
        input.field {
            border: 0;
            background-color: white;
            color: white; 
            height: 8rem;
            width: 8rem !important;
            font-family: Arial;
            font-size: 4rem;
            font-weight: normal;
            cursor: pointer;
        }
        input.field:hover {
            border: 0;
            color: #c81657; 
        }
        table.tic input{
            width: 2rem;
        }
        .colorX { color: #e77; } 
        .colorO { color: #77e; } 
        table.tic { border-collapse: collapse; }
    </style>
    
    </head>
<body class="bg-colorESFLGruen">
    <header class="container">
        <p class="textWhite">The header is usually the place for a logo or a picture, a navigation bar or a search field.</p>
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.php"><img src="img/esfllogo.png" class="navbar-logo" alt="ESFL-Logo"/></a>
                    <p class="navbar-text">Tic-Tac-Toe</p>
                </div>
                <div class="collapse navbar-collapse" id="navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="index.php">Start new <span class="sr-only">(current)</span></a></li>
                        <li><a href="https://de.wikipedia.org/wiki/Tic-Tac-Toe" target="_blank">Über Tic-Tac-Toe</a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    
    <section class="container bg-colorWhite">
        <h1 class="bg-colorESFLBlau textWhite" style="padding: 10px;">Hi, Flensburg developers!</h1>
        <p>Here comes the first game..</p>
        <button data-target="#infotext" class="btn btn-default btn-xs" data-toggle="collapse"><span class="glyphicon glyphicon-menu-up"></span> Infotext minimieren/maximieren.</button>
        <div id="infotext" class="jumbotron col-md-12 collapse in">
            <div class="col-md-3">
                <a title="By Thomas Steiner [GFDL or CC-BY-SA-3.0], via Wikimedia Commons" href="https://commons.wikimedia.org/wiki/File%3ATictactoe1.gif" target="_blank">
                    <img alt="Tictactoe1" src="https://upload.wikimedia.org/wikipedia/commons/3/33/Tictactoe1.gif" class="img-responsive img-rounded"/>
                </a>
            </div>
            <div class="col-md-9">
                <p>Tic-Tac-Toe (auch: Drei gewinnt, Kreis und Kreuz, Dodelschach) ist ein klassisches, einfaches Zweipersonen-Strategiespiel, dessen Geschichte sich bis ins 12. Jahrhundert v. Chr. zurückverfolgen lässt...<br/> <small><a href="https://en.wikipedia.org/wiki/Tic-tac-toe" target="_blank">(bei Wikipedia weiterlesen...)</a></small></p>
                <p class="bg-info" style="padding: 10px;"> <?php echo $currentPlayer->getNickname(); ?> spielt das <b><?php echo $currentPlayer->getToken(); ?></b> und darfst beginnen. Klicke hierzu in das gewünschte Feld auf dem Spielfeld...</p>
            </div>
        </div>
        
        <article id="mainContent">
            <?php if ($_SESSION['winner'] != null) { ?>
            <div>
                <p class="bg-info" style="padding: 10px;"> Der Spieler <?php echo $currentPlayer->getNickname(); ?> hat gewonnen!
                Wollen Sie nochmal spielen?</p>
                <form action="index.php" method="get"><button type="submit" name="reset" value="1">Reset</button></form>

                
            </div>
            <?php } else { ?>
            <div class="row level1">
                <div class="col-md-offset-4 col-md-4">
                    <form method="get" action="index.php">
                        <table class="tic" style="border-collapse: collapse">
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
                </div>
            </div>
           <?php } ?> 
        </article>
    </section>
    
    <footer class="container bg-colorESFLGelb" style="padding-top: 20px; padding-bottom: 20px;">
        <div class="col-md-6">
            <p>And here is some text in the footer. <br />And always make sure your html is valid here: <a class="btn btn-info btn-xs" role="button" href="https://validator.w3.org/#validate_by_input" target="_blank">https://validator.w3.org/#validate_by_input</a></p>
        </div>
        <div class="col-md-6">
            <p class="text-right"><span class="glyphicon glyphicon-copyright-mark"></span> <span class="text-capitalize">by Anwendungsentwicklung IT-B2-25</span><br /><a href="http://www.esfl.de/" target="_blank">Eckener-Schule Flensburg<br /><img src="img/esfllogo-white.png" class="footer-logo img-rounded" alt="ESFL-Logo"/></a></p>
        </div>
    </footer>
    
    <script src="./js/jquery.min.js"></script>
    <script src="./js/bootstrap.js"></script>
    <script src="./js/script.js"></script>
</body>
</html>