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
    <legend>Add</legend>
    <p>
        <label>Title:<br>
        <input type="text" name="movieTitle" value=""/>
        </label>
    </p>

    <p>
        <label>Year:<br>
        <input type="number" name="movieYear" value=""/>
    </p>

    <p>
        <label>Image:<br>
        <input type="text" name="movieImage"
            value="img/noimage.png" placeholder="img/noimage.png" readonly/>
        </label>
    </p>

    <p>
        <input type="submit" name="doAdd" value="Add">
    </p>
    <p>
        <a href="<?= url("movie1/index") ?>">Back</a>
    </p>
    </fieldset>
</form>
