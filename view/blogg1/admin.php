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
<table>
    <tr class="first">
        <th>Id</th>
        <th>Title</th>
        <th>Type</th>
        <th>Published</th>
        <th>Created</th>
        <th>Updated</th>
        <th>Deleted</th>
        <th>Actions</th>
    </tr>
<?php $id = -1; foreach ($res as $row) :
    $id++; ?>
    <tr>
        <td><?= $row->id ?></td>
        <td><?= $row->title ?></td>
        <td><?= $row->type ?></td>
        <td><?= $row->published ?></td>
        <td><?= $row->created ?></td>
        <td><?= $row->updated ?></td>
        <td><?= $row->deleted ?></td>
        <td>
            <a class="icons" href="<?= url("blogg1/edit?id=$row->id") ?>" title="Edit this content">
                Edit
            </a>
            <a class="icons" href="<?= url("blogg1/delete?id=$row->id") ?>" title="Edit this content">
                Delete
            </a>
        </td>
    </tr>
<?php endforeach; ?>
</table>
