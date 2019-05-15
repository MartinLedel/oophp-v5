<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

if (!$res) {
    return;
}
?>
<ul class="left-list">
    <li><a href="<?= url("movie1/index") ?>">Visa alla filmer</a></li>
    <li><a href="<?= url("movie1/search-title") ?>">Sök titel</a></li>
    <li><a href="<?= url("movie1/search-year") ?>">Sök år</a></li>
    <li><a href="<?= url("movie1/add") ?>">Add movie</a></li>
</ul>
<table>
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
        <td><img class="thumb" src="<?= $row->image ?>"></td>
        <td><?= $row->title ?></td>
        <td><?= $row->year ?></td>
        <td><a href="<?= url("movie1/edit?movieId=$id") ?>">Edit</a></td>
        <td><a href="<?= url("movie1/delete?movieId=$id") ?>">Delete</a></td>
    </tr>
<?php endforeach; ?>
</table>
