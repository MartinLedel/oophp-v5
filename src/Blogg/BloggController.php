<?php

namespace Macy\Blogg;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class BloggController implements AppInjectableInterface
{
    use AppInjectableTrait,
        FunctionTrait;

    /**
    * @var string $db a sample member variable that gets initialised
    */
    //private $db = "not active";

    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
        return "Debug my game";
    }

    // public function initAction() : object
    // {
    //     return $this->app->response->redirect("movie/index");
    // }

    public function indexAction() : object
    {
        $title = "Bloggen index";

        $this->app->db->connect();
        $sql = "SELECT * FROM content;";
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "res" => $res,
        ];

        $this->app->page->add("blogg1/index", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function page404Action() : object
    {
        $title = "404";

        $this->app->page->add("blogg1/page404");
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function adminAction() : object
    {
        $title = "Bloggen admin";

        $this->app->db->connect();
        $sql = "SELECT * FROM content;";
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "res" => $res,
        ];

        $this->app->page->add("blogg1/admin", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function editAction() : object
    {
        $title = "Bloggen edit";
        $contentId = $this->app->request->getGet("id");

        if ($contentId && is_numeric($contentId)) {
            $this->app->db->connect();
            $sql = "SELECT * FROM content WHERE id = ?;";
            $content = $this->app->db->executeFetch($sql, [$contentId]);
        } else {
            return $this->app->response->redirect("blogg1/index");
        }

        $data = [
            "content" => $content,
        ];

        $this->app->page->add("blogg1/edit", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function editActionPost() : object
    {
        $contentId = $this->app->request->getPost("contentId");

        if ($this->app->request->getPost("doDelete")) {
            return $this->app->response->redirect("blogg1/delete?id=$contentId");
        }

        if (!is_numeric($contentId)) {
            return $this->app->response->redirect("blogg1/index");
        }

        if ($this->app->request->getPost("doSave")) {
            $params = [
                "contentTitle" => $this->app->request->getPost("contentTitle"),
                "contentPath" => $this->app->request->getPost("contentPath"),
                "contentSlug" => $this->app->request->getPost("contentSlug"),
                "contentData" => $this->app->request->getPost("contentData"),
                "contentType" => $this->app->request->getPost("contentType"),
                "contentFilter" => $this->app->request->getPost("contentFilter"),
                "contentPublish" => $this->app->request->getPost("contentPublish"),
                "contentId" => $this->app->request->getPost("contentId"),
            ];

            if (!$params["contentPath"]) {
                $params["contentPath"] = null;
            }

            if (!$params["contentSlug"]) {
                   $params["contentSlug"] = $this->slugify($params["contentTitle"]);
            }

//             $sql = <<<EOD
// UPDATE content
// SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=?
// WHERE id = ?
// ON DUPLICATE KEY UPDATE
//     slug = ? + "-fel"
// ;
// EOD;
            $sql = "UPDATE content SET title=?, path=?, slug=?, data=?, type=?, filter=?, published=? WHERE id = ?;";
            $this->app->db->connect();
            $this->app->db->execute($sql, array_values($params));
        }

        return $this->app->response->redirect("blogg1/edit?id=$contentId");
    }
    public function createAction() : object
    {
        $title = "Bloggen create";

        $this->app->page->add("blogg1/create");
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function createActionPost() : object
    {
        if ($this->app->request->getPost("doCreate")) {
            $this->app->db->connect();
            $title = $this->app->request->getPost("contentTitle");
            $sql = "INSERT INTO content (title) VALUES (?);";
            $this->app->db->execute($sql, [$title]);

            $contentId = $this->app->db->lastInsertId();
            return $this->app->response->redirect("blogg1/edit?id=$contentId");
        }

        return $this->app->response->redirect("blogg1/index");
    }
    public function deleteAction() : object
    {
        $title = "Bloggen delete";

        $contentId = $this->app->request->getGet("id");

        if ($contentId && is_numeric($contentId)) {
            $this->app->db->connect();
            $sql = "SELECT id, title FROM content WHERE id = ?;";
            $content = $this->app->db->executeFetch($sql, [$contentId]);
        } else {
            return $this->app->response->redirect("blogg1/index");
        }

        $data = [
            "content" => $content,
        ];

        $this->app->page->add("blogg1/delete", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function deleteActionPost() : object
    {
        $contentId = $this->app->request->getPost("contentId");
        if (!is_numeric($contentId)) {
            return $this->app->response->redirect("blogg1/index");
        }

        if ($this->app->request->getPost("doDelete")) {
            $this->app->db->connect();
            $sql = "UPDATE content SET deleted=NOW() WHERE id=?;";
            $this->app->db->execute($sql, [$contentId]);

            return $this->app->response->redirect("blogg1/admin");
        }

        return $this->app->response->redirect("blogg1/index");
    }
    public function pagesAction() : object
    {
        $title = "Bloggen pages";

        $this->app->db->connect();
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
        $res = $this->app->db->executeFetchAll($sql, ["page"]);

        $data = [
            "res" => $res,
        ];

        $this->app->page->add("blogg1/pages", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function pageActionGet($route) : object
    {
        $title = "Bloggen $route";
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
        $this->app->db->connect();
        $content = $this->app->db->executeFetch($sql, [$route, "page"]);
        if (!$content) {
            return $this->app->response->redirect("blogg1/page404");
        }

        $sql = "SELECT filter FROM content WHERE path = ?";
        $filter = $this->app->db->executeFetch($sql, [$route]);
        $splitfilter = explode(",", $filter->filter);
        $textfilter = new MyTextFilter2();
        $text = $textfilter->parse($content->data, $splitfilter);

        $data = [
            "content" => $content,
            "text" => $text,
        ];

        $this->app->page->add("blogg1/page", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function blogAction() : object
    {
        $title = "Bloggen blog";

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
        $this->app->db->connect();
        $res = $this->app->db->executeFetchAll($sql, ["post"]);

        $data = [
            "res" => $res,
        ];

        $this->app->page->add("blogg1/blog", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function blogpostActionGet($route) : object
    {
        $title = "Bloggen $route";
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
        $this->app->db->connect();
        $content = $this->app->db->executeFetch($sql, [$route, "post"]);
        if (!$content) {
            return $this->app->response->redirect("blogg1/page404");
        }

        $sql = "SELECT filter FROM content WHERE slug = ?";
        $filter = $this->app->db->executeFetch($sql, [$route]);
        $splitfilter = explode(",", $filter->filter);
        $textfilter = new MyTextFilter2();
        $text = $textfilter->parse($content->data, $splitfilter);

        $data = [
            "content" => $content,
            "text" => $text,
        ];

        $this->app->page->add("blogg1/blogpost", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
