<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to game
 */
$app->router->get("guess/init", function () use ($app) {

    $_SESSION = [];
    $game = new Macy\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();
    return $app->response->redirect("guess/play");
});



/**
 * Play the game - show game status
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";

    // Deal with incoming SESSION
    $number = $_SESSION["number"] ?? null;
    $tries = $_SESSION["tries"] ?? null;
    $res = $_SESSION["res"] ?? null;
    $gameGuess = $_SESSION["gameGuess"] ?? null;
    $gameCheat = $_SESSION["gameCheat"] ?? null;

    $_SESSION["res"] = null;
    $_SESSION["guess"] = null;

    $data = [
        "number" => $number,
        "tries" => $tries,
        "res" => $res,
        "gameGuess" => $gameGuess,
        "gameCheat" => $gameCheat,
    ];

    $app->page->add("guess/play", $data);
    // $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Play the game - make a guess
 */
$app->router->post("guess/play", function () use ($app) {

    // Deal with incoming POST
    $_SESSION["guess"] = $_POST["guess"] ?? null;
    $_SESSION["gameGuess"] = $_POST["gameGuess"] ?? null;
    $_SESSION["gameInit"] = $_POST["gameInit"] ?? null;
    $_SESSION["gameCheat"] = $_POST["gameCheat"] ?? null;

    if ($_SESSION["gameInit"]) {
        return $app->response->redirect("guess/start-over");
    }

    return $app->response->redirect("guess/make-guess");
});

/**
 * Play the game - make a guess
 */
$app->router->get("guess/make-guess", function () use ($app) {

    // Deal with incoming session
    $guess = $_SESSION["guess"];
    $gameGuess = $_SESSION["gameGuess"];
    $number = $_SESSION["number"];
    $tries = $_SESSION["tries"];

    if ($gameGuess && $guess) {
        try {
            $game = new Macy\Guess\Guess($number, $tries);
            $res = $game->makeGuess(intval($guess));
            $_SESSION["res"] = $res;
            $_SESSION["tries"] = $game->tries();
            $_SESSION["guess"] = $guess;
        } catch (Macy\Guess\GuessException $e) {
            $res = "Guess is only allowed to be from 1 - 100";
            $_SESSION["res"] = $res;
        }
    }

    return $app->response->redirect("guess/play");
});

$app->router->get("guess/start-over", function () use ($app) {

    $_SESSION = [];

    $game = new Macy\Guess\Guess();
    $_SESSION["number"] = $game->number();
    $_SESSION["tries"] = $game->tries();

    return $app->response->redirect("guess/play");
});
