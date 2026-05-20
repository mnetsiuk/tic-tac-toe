<?php
class Player
{
    private $nickname;
    private $token;

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
    public function setNickname($input)
    {
        $safeInput = trim(htmlspecialchars($input));
        if ($safeInput === '' || strlen($safeInput) >= 20) {
            throw new Exception('Nickname error');
        } else {
            $this->nickname = $safeInput;
        }
    }

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
