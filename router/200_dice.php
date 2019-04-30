<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
* Inits the game by reseting the session and starts a new game
* also rolls the first throw to decided which player that starts.
*/
$app->router->get("dice/init", function () use ($app) {

    $_SESSION = [];
    // Roll for starting player
    $player1 = new Macy\Dice\Dice();
    $computer = new Macy\Dice\Dice();
    $player1roll = $player1->roll();
    $computerroll = $computer->roll();
    if ($player1roll > $computerroll) {
        $game = new Macy\Dice\DiceHandler("Player");
        $_SESSION["player"] = "Player";
    } else {
        $game = new Macy\Dice\DiceHandler("Computer");
        $_SESSION["computer"] = "Computer";
    }
    // Init game and score into session
    $_SESSION["game"] = $game;
    $_SESSION["scores"] = $game->getPlayerScore();
    return $app->response->redirect("dice/play");
});



/**
 * Play the game - show game status
 */
$app->router->get("dice/play", function () use ($app) {
    $title = "Play the game";

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

    $app->page->add("dice/play", $data);
    $app->page->add("dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Catch the POST and play-dice or start over
 */
$app->router->post("dice/play", function () use ($app) {

    // Deal with incoming POST
    $_SESSION["computer"] = $_POST["computer"] ?? null;
    $_SESSION["doInit"] = $_POST["doInit"] ?? null;
    $_SESSION["doSave"] = $_POST["doSave"] ?? null;

    // Route to reinit the game
    if ($_SESSION["doInit"]) {
        return $app->response->redirect("dice/init");
    }
    // Route to save the player score
    if ($_SESSION["doSave"]) {
        return $app->response->redirect("dice/save-score");
    }

    if ($_SESSION["computer"]) {
        return $app->response->redirect("dice/computer-dice");
    }

    return $app->response->redirect("dice/play-dice");
});

/**
 * Play the game - roll the dices
 */
$app->router->get("dice/play-dice", function () use ($app) {

    $game = $_SESSION["game"];
    $_SESSION["scores"] = $game->rollForScore();
    $_SESSION["lastroll"] = $game->getLastRoll();
    $_SESSION["player"] = $game->getCurrentPlayer();
    $currentplayerscore = $game->getCurrentPlayerScore("Player");
    //Check if the score is over 100 to determine winner
    if ($currentplayerscore >= 100) {
        $_SESSION["winner"] = $game->getCurrentPlayer();
    }

    return $app->response->redirect("dice/play");
});

/**
 * Computer roll the dices
 */
$app->router->get("dice/computer-dice", function () use ($app) {

    $game = $_SESSION["game"];
    $_SESSION["scores"] = $game->simulateComputer();
    $_SESSION["lastroll"] = $game->getLastRoll();
    $_SESSION["player"] = $game->getCurrentPlayer();
    $currentplayerscore = $game->getCurrentPlayerScore("Computer");
    //Check if the score is over 100 to determine winner
    if ($currentplayerscore >= 100) {
        $_SESSION["winner"] = $game->getCurrentPlayer();
    }

    return $app->response->redirect("dice/play");
});

/**
 * Save the score and swap the current player
 */
$app->router->get("dice/save-score", function () use ($app) {

    $game = $_SESSION["game"];
    $_SESSION["scores"] += $game->setSavedScore();
    $_SESSION["player"] = $game->getCurrentPlayer();

    return $app->response->redirect("dice/play");
});

/**
* Resets session and starts a new game also rerolls the first throw
* to decided which player that starts.
*/
$app->router->get("dice/start-over", function () use ($app) {

    $_SESSION = [];
    // Roll for starting player
    $player1 = new Macy\Dice\Dice();
    $computer = new Macy\Dice\Dice();
    $player1roll = $player1->roll();
    $computerroll = $computer->roll();
    if ($player1roll > $computerroll) {
        $_SESSION["player"] = "Won start roll";
        $game = new Macy\Dice\DiceHandler("Player");
    } else {
        $_SESSION["computer"] = "Won start roll";
        $game = new Macy\Dice\DiceHandler("Computer");
    }
    // Reinit the game and score
    $_SESSION["game"] = $game;
    $_SESSION["scores"] = $game->getPlayerScore();

    return $app->response->redirect("dice/play");
});
