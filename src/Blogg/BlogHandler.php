<?php

namespace Macy\Blogg;

/**
 * Showing off a standard class with methods and properties.
 */
class BlogHandler
{
    public function selectRequest($db)
    {
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS published_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS published
    FROM content
WHERE type=?
ORDER BY published DESC
;
EOD;
        $db->connect();
        $res = $db->executeFetchAll($sql, ["post"]);
        return $res;
    }
    public function blogGetRequest($db, $route)
    {
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
    slug = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;
        $db->connect();
        $content = $db->executeFetch($sql, [$route, "post"]);
        return $content;
    }
    public function filterRequest($db, $route, $content)
    {
        $sql = "SELECT filter FROM content WHERE slug = ?;";
        $filter = $db->executeFetch($sql, [$route]);
        $splitfilter = explode(",", $filter->filter);
        $textfilter = new MyTextFilter2();
        $text = $textfilter->parse($content->data, $splitfilter);
        return $text;
    }
}
