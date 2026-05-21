<?php
define('BASEPATH', realpath(dirname(__FILE__)));
require_once BASEPATH . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// Start or resume the session to persist game state between page reloads
session_start();

// Handle game reset request: destroy session data and reload the page
if (isset($_GET['reset'])) {
    session_destroy();
    header('Location: index.php');
    exit();
}

// Initialize the game if there is no active session data (Step 1 & 2)
if (!isset($_SESSION['board'])) {
    $gameBoard = new Board();
    $gameBoard->reset();
    $winner = null;

    // Create players for version 0.4
    $player1 = new Player('Maksym', 'X');
    $player2 = new Player('Olek', 'O');

    // Store the initial objects and turn order in the session
    $_SESSION['board'] = $gameBoard;
    $_SESSION['players'] = [$player1, $player2];
    $_SESSION['currentPlayerIndex'] = 0;
}

// Load current game state from the session
$gameBoard = $_SESSION['board'];
$players = $_SESSION['players'];
$currentPlayerIndex = $_SESSION['currentPlayerIndex'];

// Process user input from the View (Step 3 & 4)
foreach ($_GET as $key => $value) {
    // Look for coordinate keys formatted as 'x-y'
    if (strpos($key, '-') !== false) {
        $coordinats = explode('-', $key);
        $x = $coordinats[0];
        $y = $coordinats[1];

        $currentPlayer = $players[$currentPlayerIndex];

        try {
            // Apply the move to the board
            $gameBoard->makeMove($currentPlayer->getToken(), $x, $y);

            // Check if the last move resulted in a win
            $winner = $gameBoard->checkWiner();

            if ($winner != null) {
                // Save winner to session to trigger the victory view
                $_SESSION['winner'] = $winner;
                $_SESSION['board'] = $gameBoard;
            } else {
                // Switch turn to the other player
                if ($currentPlayerIndex === 0) {
                    $currentPlayerIndex = 1;
                } else {
                    $currentPlayerIndex = 0;
                }

                // Update session with the new state
                $_SESSION['board'] = $gameBoard;
                $_SESSION['currentPlayerIndex'] = $currentPlayerIndex;
            }
        } catch (Exception $e) {
            // Ignore invalid moves (e.g., clicking an already taken cell)
        }
    }
}
$currentPlayer = $players[$currentPlayerIndex];
?>
