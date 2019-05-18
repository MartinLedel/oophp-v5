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
<form method="post" class"movie-search">
    <fieldset>
    <legend>Edit</legend>
    <input type="hidden" name="movieId" value="<?= $movie->id ?>"/>
    <p>
        <label>Title:<br>
        <input type="text" name="movieTitle" value="<?= $movie->title ?>"/>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="movieYear" value="<?= $movie->year ?>"/>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="movieImage" value="<?= $movie->image ?>"/>
        </label>
    </p>

    <p>
        <input type="submit" name="doSave" value="Save">
        <input type="reset" value="Reset">
    </p>
    <p>
        <a href="<?= url("movie1/index") ?>">Back</a>
    </p>
    </fieldset>
</form>
