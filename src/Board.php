<?php
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

    private function checkWiner($gameBoard)
    {
        for ($i = 0; $i < count($gameBoard); $i++) {
            $lastToken = '';
            $equaleCounter = 0;
            for ($j = 0; $j < count($gameBoard[$i]); $j++) {
                if ($gameBoard[$i][$j] === '') {
                    break;
                } else {
                    if ($j === 0) {
                        $lastToken = $gameBoard[$i][$j];
                        $equaleCounter = 1;
                    } elseif ($lastToken === $gameBoard[$i][$j]) {
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
