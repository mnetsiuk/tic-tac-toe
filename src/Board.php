<?php
/**
 * Step 1: The Board class manages the 3x3 game grid and the core game logic,
 * including move validation and win detection.
 */
class Board
{
    private $board;

    public function reset()
    {
        $this->board = [['', '', ''], ['', '', ''], ['', '', '']];
    }

    public function getBoard()
    {
        return $this->board;
    }

    public function checkWiner()
    {
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

    public function makeMove($token, $x, $y)
    {
        if ($token === 'X' || $token === 'O') {
            if ($x >= 0 && $x <= 2 && $y >= 0 && $y <= 2) {
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
