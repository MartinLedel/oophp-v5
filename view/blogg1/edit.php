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
    <legend>Edit</legend>
    <input type="hidden" name="contentId" value="<?= htmlentities($content->id) ?>"/>

    <p>
        <label>Title:<br>
        <input type="text" name="contentTitle" value="<?= htmlentities($content->title) ?>"/>
        </label>
    </p>

    <p>
        <label>Path:<br>
        <input type="text" name="contentPath" value="<?= htmlentities($content->path) ?>"/>
    </p>

    <p>
        <label>Slug:<br>
        <input type="text" name="contentSlug" value="<?= htmlentities($content->slug) ?>"/>
    </p>

    <p>
        <label>Text:<br>
        <textarea name="contentData"><?= htmlentities($content->data) ?></textarea>
     </p>

     <p>
         <label>Type:<br>
         <input type="text" name="contentType" value="<?= htmlentities($content->type) ?>"/>
     </p>

     <p>
         <label>Filter:<br>
         <input type="text" name="contentFilter" value="<?= htmlentities($content->filter) ?>"/>
     </p>

     <p>
         <label>Publish:<br>
         <input type="datetime" name="contentPublish" value="<?= htmlentities($content->published) ?>"/>
     </p>

    <p>
        <button type="submit" name="doSave" value="Save">Save</button>
        <button type="reset">Reset</button>
        <button type="submit" name="doDelete" value="Delete"></i> Delete</button>
    </p>
    </fieldset>
</form>
