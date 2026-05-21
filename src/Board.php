<?php
/**
 * The Board class manages the 3x3 game grid and the core game logic,
 * including move validation and win detection.
 */
class Board
{
    private $board;

    // Resets the game board by creating an empty 3x3 multidimensional array
    public function reset()
    {
        $this->board = [['', '', ''], ['', '', ''], ['', '', '']];
    }

    public function getBoard()
    {
        return $this->board;
    }

    // Evaluates the current board state to determine if there is a winner
    public function checkWiner()
    {
        // Check all rows for a winning combination (3 identical tokens)
        for ($i = 0; $i < count($this->board); $i++) {
            $lastToken = '';
            $equaleCounter = 0;
            for ($j = 0; $j < count($this->board[$i]); $j++) {
                if ($this->board[$i][$j] === '') {
                    break;
                } else {
                    if ($j === 0) {
                        $lastToken = $this->board[$i][$j];
                        $equaleCounter = 1;
                    } elseif ($lastToken === $this->board[$i][$j]) {
                        $equaleCounter++;
                        if ($equaleCounter === 3) {
                            return $lastToken;
                        }
                    } else {
                        break;
                    }
                }
            }
        }

        // Check all columns for a winning combination
        for ($j = 0; $j < count($this->board); $j++) {
            $lastToken = '';
            $equaleCounter = 0;
            for ($i = 0; $i < count($this->board); $i++) {
                if ($this->board[$i][$j] === '') {
                    break;
                } else {
                    if ($i === 0) {
                        $lastToken = $this->board[$i][$j];
                        $equaleCounter = 1;
                    } elseif ($lastToken === $this->board[$i][$j]) {
                        $equaleCounter++;
                        if ($equaleCounter === 3) {
                            return $lastToken;
                        }
                    } else {
                        break;
                    }
                }
            }
        }
    }

    // Attempts to place a player's token on the board
    public function makeMove($token, $x, $y)
    {
        if ($token === 'X' || $token === 'O') {
            // Ensure the provided coordinates are within the 3x3 grid boundaries
            if ($x >= 0 && $x <= 2 && $y >= 0 && $y <= 2) {
                // Check if the target cell is empty before placing the token
                if ($this->board[$x][$y] === '') {
                    $this->board[$x][$y] = $token;
                    return $token;
                } else {
                    throw new Exception('Cell is already taken');
                }
            } else {
                throw new Exception('Coordinates error');
            }
        } else {
            throw new Exception('Invalid token');
        }
    }
}
?>
