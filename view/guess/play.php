<?php

namespace Macy\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

if ($tries === 1) {
    $try = "try";
} else {
    $try = "tries";
}

?>
<body>
    <h1>GUESSING GAME WITH $_POST<h1>
    <p>Lets play! Guess a number between 1 - 100, you have <?= "{$tries} {$try}" ?> left.</p>
    <form method="post">
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
    <p>CHEAT: Current number is <?= $number ?>.</p>
<?php endif; ?>
