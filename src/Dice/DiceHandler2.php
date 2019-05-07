<?php

namespace Macy\Dice;

/**
 * Showing off a standard class with methods and properties.
 */
class DiceHandler2
{

    private $playerscores = ["Player" => 0, "Computer" => 0];
    private $savedscore = ["Player" => 0, "Computer" => 0];
    private $currentplayer;
    private $lastroll = [];
    private $dice;
    private $histogram;
    private $histogramstring = "";
    private $counter;

    public function __construct(string $currentplayer)
    {
        $this->currentplayer = $currentplayer;
        $this->dice = new DiceHistogram2();
        $this->histogram = new Histogram();
    }

    public function rollForScore()
    {
        $this->lastroll = [];
        $rolls = [];
        $times = 2;
        for ($i = 0; $i < $times; $i++) {
            $this->dice->roll();
            array_push($rolls, $this->dice->getLastRoll());
        }
        $player = $this->currentplayer;
        foreach ($rolls as $value) {
            if ($value == 1) {
                $this->lastroll[$player] = $rolls;
                $this->playerscores[$player] = 0;
                $this->playerscores[$player] = $this->savedscore[$player];
                $this->setHistogram();
                $this->swapPlayer();
                return $this->playerscores;
            }
        }
        $this->playerscores[$player] += array_sum($rolls);
        $this->lastroll[$player] = $rolls;
        $this->setHistogram();
        return $this->playerscores;
    }

    public function simulateComputer()
    {
        while ($this->currentplayer == "Computer") {
            $this->counter++;
            $computerscore = $this->rollForScore();
            if ($this->currentplayer == "Computer") {
                if ($computerscore["Computer"] > 10 && $computerscore["Computer"] < 30) {
                    $this->setSavedScore();
                    break;
                } elseif ($computerscore["Computer"] > 50 && $computerscore["Computer"] < 70) {
                    $this->setSavedScore();
                    break;
                }
            }
        }
        return $this->playerscores;
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

    public function setHistogram()
    {
        $this->histogram->injectData($this->dice);
        $this->histogramstring = $this->histogram->getAsText();
    }

    public function getHistogram()
    {
        return $this->histogramstring;
    }

    public function setCounter()
    {
        $this->counter = 0;
    }

    public function getCounter()
    {
        return $this->counter;
    }
}
