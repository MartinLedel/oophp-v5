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
    private $db = "not active";

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
            $game = new DiceHandler("Player");
            $_SESSION["player"] = "Player";
        } else {
            $game = new DiceHandler("Computer");
            $_SESSION["computer"] = "Computer";
        }
        // Init game and score into session
        $_SESSION["game"] = $game;
        $_SESSION["scores"] = $game->getPlayerScore();
        return $this->app->response->redirect("dice1/play");
    }

    public function playAction() : object
    {
        $title = "Play the game (1)";

        // Deal with incoming SESSION
        $scores = $_SESSION["scores"] ?? null;
        $lastroll = $_SESSION["lastroll"] ?? null;
        $player = $_SESSION["player"] ?? null;
        $computer = $_SESSION["computer"] ?? null;
        $winner = $_SESSION["winner"] ?? null;

        $data = [
            "scores" => $scores,
            "player" => $player,
            "lastroll" => $lastroll,
            "winner" => $winner
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
        $_SESSION["computer"] = $_POST["computer"] ?? null;
        $_SESSION["doInit"] = $_POST["doInit"] ?? null;
        $_SESSION["doSave"] = $_POST["doSave"] ?? null;

        // Route to reinit the game
        if ($_SESSION["doInit"]) {
            return $this->app->response->redirect("dice1/init");
        }
        // Route to save the player score
        if ($_SESSION["doSave"]) {
            return $this->app->response->redirect("dice1/save-score");
        }

        if ($_SESSION["computer"]) {
            return $this->app->response->redirect("dice1/computer-dice");
        }

        return $this->app->response->redirect("dice1/play-dice");
    }


    public function playDiceAction() : object
    {
        $game = $_SESSION["game"];
        $_SESSION["scores"] = $game->rollForScore();
        $_SESSION["lastroll"] = $game->getLastRoll();
        $_SESSION["player"] = $game->getCurrentPlayer();
        $currentplayerscore = $game->getCurrentPlayerScore("Player");
        //Check if the score is over 100 to determine winner
        if ($currentplayerscore >= 100) {
            $_SESSION["winner"] = $game->getCurrentPlayer();
        }

        return $this->app->response->redirect("dice1/play");
    }

    public function computerDiceAction() : object
    {
        $game = $_SESSION["game"];
        $game->simulateComputer();
        $_SESSION["scores"] = $game->getPlayerScore();
        $_SESSION["lastroll"] = $game->getLastRoll();
        $_SESSION["player"] = $game->getCurrentPlayer();
        $currentplayerscore = $game->getCurrentPlayerScore("Computer");
        //Check if the score is over 100 to determine winner
        if ($currentplayerscore >= 100) {
            $_SESSION["winner"] = $game->getCurrentPlayer();
        }

        return $this->app->response->redirect("dice1/play");
    }

    public function saveScoreAction() : object
    {
        $game = $_SESSION["game"];
        $_SESSION["scores"] += $game->setSavedScore();
        $_SESSION["player"] = $game->getCurrentPlayer();

        return $this->app->response->redirect("dice1/play");
    }
}
