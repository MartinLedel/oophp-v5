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
<?php foreach ($res as $row) : ?>
<section>
    <header>
        <h1><a href="<?= url("blogg1/blogpost/" . htmlentities($row->slug)) ?>"><?= htmlentities($row->title) ?></a></h1>
        <p><i>Published: <time datetime="<?= htmlentities($row->published_iso8601) ?>" pubdate><?= htmlentities($row->published) ?></time></i></p>
    </header>
    <?= htmlentities($row->data) ?>
</section>
<?php endforeach; ?>

</article>
