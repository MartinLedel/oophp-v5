<?php
/**
 * Guess my number with POST.
 */
require(__DIR__ . "/autoload.php");
require(__DIR__ . "/config.php");

$gameInit = $_SESSION["gameInit"] ?? null;

if ($gameInit !== null) {
    $_SESSION = [];
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - 42000,
            $params["path"],
            $params["domain"],
            $params["secure"],
            $params["httponly"]
        );
    }
    session_destroy();
}

if (!isset($_SESSION["game"])) {
    $_SESSION["game"] = new Guess();
}

$object = $_SESSION["game"];

//Deal with SESSION variables
$guess = $_SESSION["guess"] ?? null;
$gameGuess = $_SESSION["gameGuess"] ?? null;
$gameCheat = $_SESSION["gameCheat"] ?? null;

$tries = $object->tries();

if ($gameGuess && $guess !== null) {
    try {
        $res = $object->makeGuess(intval($guess));
    } catch (GuessException $e) {
        $res = "Guess is only allowed to be from 1 - 100";
    }
}

$tries = $object->tries();

//Render the game page
require(__DIR__ . "/view/form.php");
