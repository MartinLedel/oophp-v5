<!doctype html>
<meta charset="utf-8">
<title>Guess game</title>
<link rel="stylesheet" href="style.css">
<?php

if ($tries === 1) {
    $try = "try";
} else {
    $try = "tries";
}

?>
<body>
    <h1>GUESSING GAME WITH $_POST<h1>
    <p>Lets play! Guess a number between 1 - 100, you have <?= "{$tries} {$try}" ?> left.</p>
    <form method="POST" action="index_process.php">
    <input type="text" name="guess" >
    <?php if ($tries === 0) : ?>
    <input type="hidden" name="gameGuess" value="Make a guess">
    <?php else : ?>
    <input type="submit" name="gameGuess" value="Make a guess">
    <?php endif; ?>
    <input type="submit" name="gameInit" value="Start from the beginning">
    <?php if ($tries === 0) : ?>
    <input type="hidden" name="gameCheat" value="Cheat">
    <?php else : ?>
    <input type="submit" name="gameCheat" value="Cheat">
    <?php endif; ?>
    </form>
</body>

<?php if ($gameGuess) : ?>
    <p><?= $res ?>.</p>
<?php endif; ?>
<?php if ($gameCheat) : ?>
    <p>CHEAT: Current number is <?= $object->number() ?>.</p>
<?php endif; ?>
