<?php

namespace Macy\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceHandlerObjectTest extends TestCase
{
    /**
     * Construct object and test if the player score is an int type.
     */
    public function testDiceHandlerRoll()
    {
        $game = new DiceHandler("Player");
        $this->assertInstanceOf("\Macy\Dice\DiceHandler", $game);

        $res = $game->rollForScore();
        $this->assertInternalType("int", $res["Player"]);
    }
    /**
     * Construct object and test if the computer score is an int type.
     */
    public function testDiceHandlerComputerRoll()
    {
        $game = new DiceHandler("Computer");
        $this->assertInstanceOf("\Macy\Dice\DiceHandler", $game);

        $game->simulateComputer();
        $res = $game->getPlayerScore();
        $this->assertInternalType("int", $res["Computer"]);
    }
    /**
     * Construct object and test if the saved score is an int type.
     */
    public function testDiceHandlerSaveScore()
    {
        $game = new DiceHandler("Computer");
        $this->assertInstanceOf("\Macy\Dice\DiceHandler", $game);

        $game->simulateComputer();
        $game->swapPlayer();
        $res = $game->setSavedScore();
        $this->assertInternalType("int", $res["Computer"]);
    }
    /**
     * Construct object and test if the last roll is an int type.
     */
    public function testDiceHandlerLastRoll()
    {
        $game = new DiceHandler("Computer");
        $this->assertInstanceOf("\Macy\Dice\DiceHandler", $game);

        $game->simulateComputer();
        $res = $game->getLastRoll();
        $res = $game->setSavedScore();
        $this->assertInternalType("int", $res["Computer"]);
    }
}
