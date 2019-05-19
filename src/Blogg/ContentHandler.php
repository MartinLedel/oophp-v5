<?php

namespace Macy\Blogg;

/**
 * Showing off a standard class with methods and properties.
 */
class ContentHandler
{
    public function selectRequest($db)
    {
        $db->connect();
        $sql = "SELECT * FROM content;";
        $res = $db->executeFetchAll($sql);
        return $res;
    }
    public function searchRequest($db, $request)
    {
        $db->connect();
        $sql = "SELECT * FROM content WHERE id = ?;";
        $content = $db->executeFetch($sql, [$request]);
        return $content;
    }
    public function editRequest($db, $request1, $request2)
    {
        $sql = "SELECT slug FROM content WHERE slug = ?;";
        $slug = $request1["contentSlug"];
        $db->connect();
        $slugChecker = $db->executeFetch($sql, [$slug]);
        if (!$slugChecker) {
            $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
            $db->execute($sql, array_values($request1));
        } else {
            $sql = "UPDATE content SET title=?, path=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
            $db->execute($sql, array_values($request2));
        }
    }
    public function deleteRequest($db, $request)
    {
        $db->connect();
        $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
        $db->execute($sql, [$request]);
    }
    public function createRequest($db, $title)
    {
        $db->connect();
        $sql = "INSERT INTO content (title) VALUES (?);";
        $db->execute($sql, [$title]);
        $contentId = $db->lastInsertId();
        return $contentId;
    }
}
