<?php

namespace Macy\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceObjectTest extends TestCase
{
    /**
     * Construct object and test the roll is the same as last roll.
     */
    public function testDiceRoll()
    {
        $game = new Dice();
        $this->assertInstanceOf("\Macy\Dice\Dice", $game);

        $res = $game->roll();
        $exp = $game->getLastRoll();
        $this->assertEquals($exp, $res);
    }
    /**
     * Construct an object but with one less side.
     * Test if it still has same lastRoll
     */
    public function testDiceRollSides()
    {
        $game = new Dice(5);
        $this->assertInstanceOf("\Macy\Dice\Dice", $game);

        $res = $game->roll();
        $exp = $game->getLastRoll();
        $this->assertEquals($exp, $res);
    }
    /**
     * Construct object with only 1 side. Test if is has the
     * expected roll.
     */
    public function testLastRoll()
    {
        $game = new Dice(1);
        $this->assertInstanceOf("\Macy\Dice\Dice", $game);

        $res = $game->roll();
        $exp = 1;
        $this->assertEquals($exp, $res);
    }
}
