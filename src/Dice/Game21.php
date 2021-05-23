<?php

declare(strict_types=1);

namespace gusu20\Dice;

class Game21 extends DiceHand
{
    public function __construct()
    {
        parent::__construct($_SESSION["diceAmount"]);
    }

    public function player() 
    {
        $this->rollDices();
        $this->getDicesValue();
        $sum = $this->getDiceSum();
        $_SESSION["playerSum"] += $sum;
        $dices = $this->getDicesGraphic();
        $_SESSION["playerDices"] = $dices;

        if ($_SESSION["playerSum"] == 21) {
            $_SESSION["stats"] = "Du vann!";
            $_SESSION["playerWins"] += 1;
        } else if ($_SESSION["playerSum"] > 21) {
            $_SESSION["stats"] = "Datorn vann!";
            $_SESSION["comWins"] += 1;
        }
    }

    public function com() 
    {
        while ($_SESSION["comSum"] <= $_SESSION["playerSum"]) {
            $this->rollDices();
            $this->getDicesValue();
            $sum = $this->getDiceSum();
            $_SESSION["comSum"] += $sum;

            if ((int)$_SESSION["comSum"] > $_SESSION["playerSum"] && (int)$_SESSION["comSum"] < 21 || (int)$_SESSION["comSum"] == 21) {
                $_SESSION["comWins"] += 1;
                $_SESSION["stats"] = "Datorn vann!";   
            } else if ((int)$_SESSION["comSum"] > 21) {
                $_SESSION["stats"] = "Du vann!";
                $_SESSION["playerWins"] += 1;
            }
        }
    }
}
