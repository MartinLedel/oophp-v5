<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

?>
<nav class="nav-blogg">
    <a href="<?= url("blogg1/index") ?>">Show all content</a>
    <a href="<?= url("blogg1/admin") ?>">Admin</a>
    <a href="<?= url("blogg1/create") ?>">Create</a>
    <a href="<?= url("blogg1/pages") ?>">View pages</a>
    <a href="<?= url("blogg1/blog") ?>">View blog</a>
</nav>
<article>
    <header>
        <h1><?= htmlentities($content->title) ?></h1>
        <p><i>Latest update: <time datetime="<?= htmlentities($content->modified_iso8601) ?>" pubdate><?= htmlentities($content->modified) ?></time></i></p>
    </header>
    <?= $text ?>
</article>
