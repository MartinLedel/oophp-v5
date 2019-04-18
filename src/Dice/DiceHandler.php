<?php

namespace Macy\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class DiceHandler
{

    private $playerscores;
    private $currentplayer;
    private $lastroll;
    private $savedscore;

    public function __construct(string $currentplayer)
    {
        $this->playerscores = ["Player" => 0, "Computer" => 0];
        $this->savedscore = ["Player" => 0, "Computer" => 0];
        $this->currentplayer = $currentplayer;
        $this->lastroll = [];
    }

    public function rollForScore()
    {
        $this->lastroll = [];
        $hand = new DiceHand();
        $hand->roll();
        $rolls = $hand->values();
        $player = $this->currentplayer;
        foreach ($rolls as $value) {
            if ($value == 1) {
                $this->lastroll[$player] = $rolls;
                $this->playerscores[$player] = 0;
                $this->swapPlayer();
                return $this->playerscores;
            }
        }
        $this->playerscores[$player] += $hand->sum();
        $this->lastroll[$player] = $rolls;
        return $this->playerscores;
    }

    public function simulateComputer()
    {
        $player = $this->getCurrentPlayer();
        while ($player == "Computer") {
            $this->rollForScore();
            $computerscore = $this->getCurrentPlayerScore("Computer");
            $player = $this->getCurrentPlayer();
            if ($computerscore > 10 && $computerscore < 30) {
                $this->setSavedScore();
                break;
            } elseif ($computerscore > 50 && $computerscore < 70) {
                $this->setSavedScore();
                break;
            }
        }
    }

    public function swapPlayer()
    {
        if ($this->currentplayer === "Player") {
            $this->currentplayer = "Computer";
        } else {
            $this->currentplayer = "Player";
        }
    }

    public function getPlayerScore()
    {
        return $this->playerscores;
    }

    public function getCurrentPlayer()
    {
        return $this->currentplayer;
    }

    public function getCurrentPlayerScore(string $player)
    {
        return $this->playerscores[$player];
    }

    public function getLastRoll()
    {
        return $this->lastroll;
    }

    public function setSavedScore()
    {
        $player = $this->currentplayer;
        $this->savedscore[$player] = $this->playerscores[$player];
        $this->swapPlayer();
        return $this->savedscore;
    }
}
