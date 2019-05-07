<?php

namespace Macy\Dice;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DiceHandler2ObjectTest extends TestCase
{
    /**
     * Construct object and test if the player score is an int type.
     */
    public function testDiceHandler2Roll()
    {
        $game = new DiceHandler2("Player");
        $this->assertInstanceOf("\Macy\Dice\DiceHandler2", $game);

        $res = $game->rollForScore();
        $this->assertInternalType("int", $res["Player"]);
    }
    /**
     * Construct object and test if the computer score is an int type.
     */
    public function testDiceHandler2ComputerRoll()
    {
        $game = new DiceHandler2("Computer");
        $this->assertInstanceOf("\Macy\Dice\DiceHandler2", $game);

        for ($i = 0; $i < 6; $i++) {
            $game->simulateComputer();
        }

        $game->simulateComputer();
        $res = $game->getPlayerScore();
        $this->assertInternalType("int", $res["Computer"]);
    }
    /**
     * Construct object and test if the saved score is an int type.
     */
    public function testDiceHandler2SaveScore()
    {
        $game = new DiceHandler2("Computer");
        $this->assertInstanceOf("\Macy\Dice\DiceHandler2", $game);

        $game->simulateComputer();
        $game->swapPlayer();
        $res = $game->setSavedScore();
        $this->assertInternalType("int", $res["Computer"]);
    }
    /**
     * Construct object and test if the last roll is an int type.
     */
    public function testDiceHandler2LastRoll()
    {
        $game = new DiceHandler2("Computer");
        $this->assertInstanceOf("\Macy\Dice\DiceHandler2", $game);

        $game->simulateComputer();
        $res = $game->getLastRoll();
        $res = $game->setSavedScore();
        $this->assertInternalType("int", $res["Computer"]);
    }
    /**
     * Construct object and test if the player and score is correct.
     */
    public function testDiceHandler2GetPlayerAndScore()
    {
        $game = new DiceHandler2("Player");
        $this->assertInstanceOf("\Macy\Dice\DiceHandler2", $game);

        $player = $game->getCurrentPlayer();
        $this->assertEquals("Player", $player);

        $score = $game->getCurrentPlayerScore($player);
        $this->assertEquals(0, $score);
    }
    /**
     * Construct object and test if the player and score is correct.
     */
    public function testDiceHandler2GetHistogram()
    {
        $game = new DiceHandler2("Player");
        $this->assertInstanceOf("\Macy\Dice\DiceHandler2", $game);

        for ($i=0; $i < 6; $i++) {
            $game->rollForScore();
        }

        $res = $game->getHistogram();
        $this->assertInternalType("string", $res);
    }
    /**
     * Construct object and test if the player and score is correct.
     */
    public function testDiceHandler2Counter()
    {
        $game = new DiceHandler2("Computer");
        $this->assertInstanceOf("\Macy\Dice\DiceHandler2", $game);

        $game->simulateComputer();
        $res = $game->getCounter();
        $this->assertInternalType("int", $res);

        $res2 = $game->setCounter();
        $this->assertEquals(0, $res2);
    }
}
