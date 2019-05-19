<?php

namespace Macy\Blogg;

/**
 * Showing off a standard class with methods and properties.
 */
class PageHandler
{
    public function selectRequest($db)
    {
        $db->connect();
        $sql = <<<EOD
SELECT
*,
CASE
    WHEN (deleted <= NOW()) THEN "isDeleted"
    WHEN (published <= NOW()) THEN "isPublished"
    ELSE "notPublished"
END AS status
FROM content
WHERE type=?
;
EOD;
        $res = $db->executeFetchAll($sql, ["page"]);
        return $res;
    }
    public function pageGetRequest($db, $request)
    {
        $sql = <<<EOD
SELECT
    *,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%dT%TZ') AS modified_iso8601,
    DATE_FORMAT(COALESCE(updated, published), '%Y-%m-%d') AS modified
FROM content
WHERE
    path = ?
    AND type = ?
    AND (deleted IS NULL OR deleted > NOW())
    AND published <= NOW()
;
EOD;
        $db->connect();
        $content = $db->executeFetch($sql, [$request, "page"]);
        return $content;
    }
    public function filterRequest($db, $route, $content)
    {
        $sql = "SELECT filter FROM content WHERE path = ?;";
        $filter = $db->executeFetch($sql, [$route]);
        $splitfilter = explode(",", $filter->filter);
        $textfilter = new MyTextFilter2();
        $text = $textfilter->parse($content->data, $splitfilter);
        return $text;
    }
}
