<?php
/**
 * Step 2 & 4: The Game class acts as the main controller for the match.
 * It encapsulates the board, the players, and the turn logic.
 */
class Game
{
    private $board;
    private $players;
    private $currentPlayerIndex;
    private $winner;

    public function __construct($player1Name, $player1Token, $player2Name, $player2Token)
    {
        $this->board = new Board();
        $this->board->reset();

        // Storing Player objects inside the Game class
        $this->players = [
            new Player($player1Name, $player1Token),
            new Player($player2Name, $player2Token),
        ];

        $this->currentPlayerIndex = 0;
        $this->winner = null;
    }

    public function getBoard()
    {
        return $this->board;
    }

    public function getCurrentPlayer()
    {
        return $this->players[$this->currentPlayerIndex];
    }

    public function getWinner()
    {
        return $this->winner;
    }

    // Handles a player's turn and checks for a win
    public function playTurn($x, $y)
    {
        if ($this->winner != null) {
            return;
        }

        $currentPlayer = $this->getCurrentPlayer();

        try {
            $this->board->makeMove($currentPlayer->getToken(), $x, $y);
            $this->winner = $this->board->checkWiner();

            if ($this->winner == null) {
                if ($this->currentPlayerIndex === 0) {
                    $this->currentPlayerIndex = 1;
                } else {
                    $this->currentPlayerIndex = 0;
                }
            }
        } catch (Exception $e) {
            // Ignore invalid moves
        }
    }
}
?>
