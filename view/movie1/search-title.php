<?php

namespace Anax\View;

/**
 * Render content within an article.
 */
?>
<ul class="left-list">
    <li><a href="<?= url("movie1/index") ?>">Visa alla filmer</a></li>
    <li><a href="<?= url("movie1/search-title") ?>">Sök titel</a></li>
    <li><a href="<?= url("movie1/search-year") ?>">Sök år</a></li>
    <li><a href="<?= url("movie1/add") ?>">Add movie</a></li>
</ul>
<form method="get" class="movie-search">
    <fieldset>
    <legend>Search</legend>
    <p>
        <label>Title (use % as wildcard):
            <input type="search" name="searchTitle" value="<?= htmlentities($searchTitle) ?>"/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
    </p>
    <p><a href="<?= url("movie1/search-title") ?>">Show all</a></p>
    </fieldset>
</form>
<table class="movie-box">
    <tr class="first">
        <th>Rad</th>
        <th>Id</th>
        <th>Bild</th>
        <th>Titel</th>
        <th>År</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $id ?></td>
        <td><?= $row->id ?></td>
        <td><img class="thumb" src="<?= asset($row->image)?>"></td>
        <td><?= $row->title ?></td>
        <td><?= $row->year ?></td>
    </tr>
<?php endforeach; ?>
</table>
