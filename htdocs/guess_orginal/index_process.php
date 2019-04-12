<?php
require(__DIR__ . "/autoload.php");
require(__DIR__ . "/config.php");

$_SESSION["guess"] = $_POST["guess"] ?? null;
$_SESSION["gameInit"] = $_POST["gameInit"] ?? null;
$_SESSION["gameGuess"] = $_POST["gameGuess"] ?? null;
$_SESSION["gameCheat"] = $_POST["gameCheat"] ?? null;

// var_dump($_SESSION);
// Redirect to a result page.
$url = "index.php";
header("Location: $url");
