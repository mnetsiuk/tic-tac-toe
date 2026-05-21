<?php
/**
 * The Player class manages the data for a single game participant,
 * including their display name and their game piece (token).
 */
class Player
{
    private $nickname;
    private $token;

    // Initializes a new player and validates the input data
    public function __construct($playerName, $playerToken)
    {
        $this->setNickname($playerName);
        $this->setToken($playerToken);
    }

    public function getNickname()
    {
        return $this->nickname;
    }

    public function getToken()
    {
        return $this->token;
    }

    // Validates and sets the nickname. Ensures it's not empty or too long.
    public function setNickname($input)
    {
        $safeInput = trim(htmlspecialchars($input));
        if ($safeInput === '' || strlen($safeInput) >= 20) {
            throw new Exception('Nickname error');
        } else {
            $this->nickname = $safeInput;
        }
    }

    // Validates and sets the token. Only allows standard 'X' or 'O' pieces.
    public function setToken($argToken)
    {
        if ($argToken === 'X' || $argToken === 'O') {
            $this->token = $argToken;
        } else {
            throw new Exception('Error token');
        }
    }
}
?>
