<?php

declare(strict_types=1);

namespace gusu20\Dice;

class GraphicalDice extends Dice
{
    public function __construct()
    {
        parent::__construct(6);
    }

    public function dicesGraphic()
    {
        return "dice-" . $this->getLastRoll();
    }
}