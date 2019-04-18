<?php

namespace Macy\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceHandObjectTest extends TestCase
{
    /**
     * Construct object and test if is has the correct amount
     * of rolls.
     */
    public function testDiceRollAndValues()
    {
        $hand = new DiceHand();
        $this->assertInstanceOf("\Macy\Dice\DiceHand", $hand);

        $hand->roll();
        $res = $hand->values();
        $exp = 5;
        $this->assertCount($exp, $res);
    }
    /**
     * Construct object and test if the sum and average is correct.
     */
    public function testDiceSumAndAvg()
    {
        $hand = new DiceHand();
        $this->assertInstanceOf("\Macy\Dice\DiceHand", $hand);

        $hand->roll();
        $res = $hand->average();
        $values = $hand->values();
        $sum = $hand->sum();
        $exp = $sum / count($values);
        $this->assertEquals($exp, $res);
    }
    /**
     * Construct object with lots and lots of dices but also
     * test if the sum and average is correct.
     */
    public function testDiceSumAndAvgLotsOfDices()
    {
        $hand = new DiceHand(12);
        $this->assertInstanceOf("\Macy\Dice\DiceHand", $hand);

        $hand->roll();
        $res = $hand->average();
        $values = $hand->values();
        $sum = $hand->sum();
        $exp = $sum / count($values);
        $this->assertEquals($exp, $res);
    }
}
