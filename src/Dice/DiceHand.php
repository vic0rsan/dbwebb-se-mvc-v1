<?php

declare(strict_types=1);

namespace gusu20\Dice;

class DiceHand
{
    private $dicesObj = [];
    private $dicesValue = [];
    private $dicesGraphic = [];

    public function __construct(int $dices = 1)
    {
        for ($i = 0; $i < $dices; $i++) {
            $this->dicesObj[$i] = new GraphicalDice();
        }
    }

    public function rollDices()
    {
        $dices = count($this->dicesObj);
        for ($i = 0; $i < $dices; $i++) {
            $this->dicesObj[$i]->roll();
        }
    }

    public function getDicesValue()
    {
        $dices = count($this->dicesObj);
        for ($i = 0; $i < $dices; $i++) {
            $this->dicesValue[$i] = $this->dicesObj[$i]->getLastRoll();
        }
        return $this->dicesValue;
    }

    public function getDicesGraphic()
    {
        $dices = count($this->dicesObj);
        for ($i = 0; $i < $dices; $i++) {
            $this->dicesGraphic[$i] = $this->dicesObj[$i]->dicesGraphic();
        }
        return $this->dicesGraphic;
    }

    public function getDiceSum()
    {
        return array_sum($this->dicesValue);
    }

    public function setLastRoll()
    {
        $slots = $_SESSION["slots"];
        $values = $_SESSION["values"];
        $dices = count($slots);
        for ($i = 0; $i < $dices; $i++) {
            $this->dicesObj[(int)$slots[$i]]->setLastRoll($values[(int)$slots[$i]]);
        }
    }
}
