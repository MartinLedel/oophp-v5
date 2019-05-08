<?php

namespace Macy\View;

/**
 * Render content within an article.
 */

?>
<body>
<h1>Dice100 (1)</h1>
<div class="game-left">
<?php if ($winner != null) : ?>
<p><?= $winner ?> wins!</p>
<?php endif; ?>
<?php foreach ($scores as $key => $value) : ?>
<p>
    <?= $key ?>
    <br>
    <?= $value ?> points
</p>
<?php endforeach; ?>
<!-- <?php var_dump($lastroll);?> -->
<?php if (isset($lastroll)) : ?>
    <?php foreach ($lastroll as $key => $value) : ?>
<p>
        <?= $key ?> last roll
    <br>
        <?= implode(", ", $value) ?>
</p>
    <?php endforeach; ?>
<?php endif; ?>
<form method="post">
<?php if ($winner == null) : ?>
    <?php if ($player == "Player") : ?>
<input type="submit" class="button blue-button" name="player" value="Player rolls">
<input type="submit" class="button" name="doSave" value="Save score">
    <?php else : ?>
<input type="submit" class="button blue-button" name="computer" value="Simulate computer">
    <?php endif; ?>
<?php endif; ?>
<input type="submit" class="button green-button" name="doInit" value="Reset">
</form>
</div>
<div class="game-right">
<p>
    Histogram <br>
    <?php if ($counter) : ?>
        <?php if ($counter == 1) : ?>
        Computer rolled <?= $counter ?> time
        <?php else : ?>
        Computer rolled <?= $counter ?> times
        <?php endif; ?>
    <?php endif; ?>
</p>
<pre><?= $histogram ?></pre>
</div>
</body>
