<?php

declare(strict_types=1);

namespace gusu20\Dice;

class Dice
{
    private $faces;
    private $lastRoll;

    public function __construct(int $faces = 6)
    {
        $this->faces = $faces;    
    }

    public function roll()
    {
        $value = rand(1, $this->faces);
        $this->lastRoll = $value;
    }

    public function getLastRoll()
    {
        return $this->lastRoll;
    }
}
