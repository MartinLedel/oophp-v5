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
<form method="post">
    <fieldset>
    <legend>Create</legend>
    <p>
        <label>Title:<br>
        <input type="text" name="contentTitle" value=""/>
        </label>
    </p>
        <button type="submit" name="doSave" value="Save">Save</button>
        <button type="reset">Reset</button>
    </p>
    </fieldset>
</form>
