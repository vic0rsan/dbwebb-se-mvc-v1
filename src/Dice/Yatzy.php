<?php

declare(strict_types=1);

namespace gusu20\Dice;

class Yatzy extends DiceHand
{
    public function __construct()
    {
        parent::__construct(5);
    }

    public function rollYatzy()
    {
        $this->rollDices();
        $this->setLastRoll();
        $values = $this->getDicesValue();
        $_SESSION["values"] = $values;
        $dices = $this->getDicesGraphic();
        $_SESSION["yatzyDices"] = $dices;
    }
    
    public function getRounds()
    {
        $_SESSION["rolls"] += 1;
        $_SESSION["tries"] -= 1;
        if ($_SESSION["tries"] == -1) {
            $this->getYatzySum();
            $_SESSION["tries"] = 3;
            $_SESSION["rounds"] += 1;
            $_SESSION["slots"] = array();
        }
    }

    public function getYatzySum()
    {
        $rounds = $_SESSION["rounds"];
        $values = $_SESSION["values"];
        $slots = $_SESSION["slots"];
        $dices = count($slots);
        $sum = 0;
        for ($i = 0; $i < $dices; $i++) {
            if ($values[(int)$slots[$i]] == $rounds) {
                $sum += $values[(int)$slots[$i]];
            }
        }
        $_SESSION["sum"] += $sum;
        if ($sum >= 63) { 
            $_SESSION["sum"] += 35; 
        }
    }
}
