<?php

namespace Macy\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class Dice
{

    protected $sides;
    private $lastRoll;

    public function __construct(int $sides = 6)
    {
        $this->sides = $sides;
    }

    public function roll()
    {
        $this->lastRoll = rand(1, $this->sides);
        return  $this->lastRoll;
    }

    public function getLastRoll()
    {
        return $this->lastRoll;
    }
}
