<?php

namespace Macy\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;

    /**
    * @var string $db a sample member variable that gets initialised
    */
    //private $db = "not active";

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "Debug my game";
    }

    public function initAction() : object
    {
        $_SESSION = [];
        // Roll for starting player
        $player1 = new Dice();
        $computer = new Dice();
        $player1roll = $player1->roll();
        $computerroll = $computer->roll();
        if ($player1roll > $computerroll) {
            $game = new DiceHandler2("Player");
            $this->app->session->set("player", "Player");
        } else {
            $game = new DiceHandler2("Computer");
            $this->app->session->set("computer", "Computer");
        }
        // Init game and score into session
        $this->app->session->set("game", $game);
        $this->app->session->set("scores", $game->getPlayerScore());
        return $this->app->response->redirect("dice1/play");
    }

    public function playAction() : object
    {
        $title = "Play the game (1)";

        // Deal with incoming SESSION
        $scores = $this->app->session->get("scores");
        $lastroll = $this->app->session->get("lastroll");
        $player = $this->app->session->get("player");
        $winner = $this->app->session->get("winner");
        $game = $this->app->session->get("game");
        $histogram = $game->getHistogram();
        $counter = $game->getCounter();
        $game->setCounter();

        $data = [
            "scores" => $scores,
            "player" => $player,
            "lastroll" => $lastroll,
            "winner" => $winner,
            "histogram" => $histogram,
            "counter" => $counter
        ];

        $this->app->page->add("dice1/play", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }

    public function playActionPost() : object
    {
        // Deal with incoming POST
        $computer = $this->app->request->getPost("computer");
        $this->app->session->set("computer", $computer);
        $doinit = $this->app->request->getPost("doInit");
        $this->app->session->set("doInit", $doinit);
        $dosave = $this->app->request->getPost("doSave");
        $this->app->session->set("doSave", $dosave);

        // Route to reinit the game
        if ($this->app->session->get("doInit")) {
            return $this->app->response->redirect("dice1/init");
        }
        // Route to save the player score
        if ($this->app->session->get("doSave")) {
            return $this->app->response->redirect("dice1/save-score");
        }

        if ($this->app->session->get("computer")) {
            return $this->app->response->redirect("dice1/computer-dice");
        }

        return $this->app->response->redirect("dice1/play-dice");
    }


    public function playDiceAction() : object
    {
        $game = $this->app->session->get("game");
        $this->app->session->set("scores", $game->rollForScore());
        $this->app->session->set("lastroll", $game->getLastRoll());
        $this->app->session->set("player", $game->getCurrentPlayer());
        $currentplayerscore = $game->getCurrentPlayerScore("Player");
        //Check if the score is over 100 to determine winner
        if ($currentplayerscore >= 100) {
            $this->app->session->set("winner", $game->getCurrentPlayer());
        }

        return $this->app->response->redirect("dice1/play");
    }

    public function computerDiceAction() : object
    {
        $game = $this->app->session->get("game");
        $this->app->session->set("scores", $game->simulateComputer());
        $this->app->session->set("lastroll", $game->getLastRoll());
        $this->app->session->set("player", $game->getCurrentPlayer());
        $currentplayerscore = $game->getCurrentPlayerScore("Computer");
        //Check if the score is over 100 to determine winner
        if ($currentplayerscore >= 100) {
            $this->app->session->set("winner", $game->getCurrentPlayer());
        }

        return $this->app->response->redirect("dice1/play");
    }

    public function saveScoreAction() : object
    {
        $game = $this->app->session->get("game");
        // $_SESSION["scores"] += $game->setSavedScore();
        $this->app->session->set("scores", $game->setSavedScore());
        $this->app->session->set("player", $game->getCurrentPlayer());

        return $this->app->response->redirect("dice1/play");
    }
}
