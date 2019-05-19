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
        $handler = new ContentHandler();
        $dbmodule = $this->app->db;
        $res = $handler->selectRequest($dbmodule);

        $data = [
            "res" => $res,
        ];

        $this->app->page->add("blogg1/index", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function page404Action() : object
    {
        $title = "404";

        $this->app->page->add("blogg1/page404");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function adminAction() : object
    {
        $title = "Bloggen admin";
        $handler = new ContentHandler();
        $dbmodule = $this->app->db;
        $res = $handler->selectRequest($dbmodule);

        $data = [
            "res" => $res,
        ];

        $this->app->page->add("blogg1/admin", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function editAction() : object
    {
        $title = "Bloggen edit";
        $contentId = $this->app->request->getGet("id");
        $handler = new ContentHandler();
        $dbmodule = $this->app->db;

        if ($contentId && is_numeric($contentId)) {
            $content = $handler->searchRequest($dbmodule, $contentId);
        } else {
            return $this->app->response->redirect("blogg1/index");
        }

        $data = [
            "content" => $content,
        ];

        $this->app->page->add("blogg1/edit", $data);

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

            $params2 = [
                "contentTitle" => $this->app->request->getPost("contentTitle"),
                "contentPath" => $this->app->request->getPost("contentPath"),
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

            $handler = new ContentHandler();
            $dbmodule = $this->app->db;
            $handler->editRequest($dbmodule, $params, $params2);
        }

        return $this->app->response->redirect("blogg1/edit?id=$contentId");
    }
    public function createAction() : object
    {
        $title = "Bloggen create";

        $this->app->page->add("blogg1/create");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function createActionPost() : object
    {
        if ($this->app->request->getPost("doCreate")) {
            $handler = new ContentHandler();
            $dbmodule = $this->app->db;
            $title = $this->app->request->getPost("contentTitle");
            $contentId = $handler->createRequest($dbmodule, $title);

            return $this->app->response->redirect("blogg1/edit?id=$contentId");
        }

        return $this->app->response->redirect("blogg1/index");
    }
    public function deleteAction() : object
    {
        $title = "Bloggen delete";
        $handler = new ContentHandler();
        $dbmodule = $this->app->db;
        $contentId = $this->app->request->getGet("id");

        if ($contentId && is_numeric($contentId)) {
            $content = $handler->searchRequest($dbmodule, $contentId);
        } else {
            return $this->app->response->redirect("blogg1/index");
        }

        $data = [
            "content" => $content,
        ];

        $this->app->page->add("blogg1/delete", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function deleteActionPost() : object
    {
        $contentId = $this->app->request->getPost("contentId");
        $handler = new ContentHandler();
        $dbmodule = $this->app->db;
        if (!is_numeric($contentId)) {
            return $this->app->response->redirect("blogg1/index");
        }

        if ($this->app->request->getPost("doDelete")) {
            $handler->deleteRequest($dbmodule, $contentId);

            return $this->app->response->redirect("blogg1/admin");
        }

        return $this->app->response->redirect("blogg1/index");
    }
    public function pagesAction() : object
    {
        $title = "Bloggen pages";
        $handler = new PageHandler();
        $dbmodule = $this->app->db;

        $res = $handler->selectRequest($dbmodule);

        $data = [
            "res" => $res,
        ];

        $this->app->page->add("blogg1/pages", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function pageActionGet($route) : object
    {
        $title = "Bloggen $route";
        $handler = new PageHandler();
        $dbmodule = $this->app->db;
        $content = $handler->pageGetRequest($dbmodule, $route);

        if (!$content) {
            return $this->app->response->redirect("blogg1/page404");
        }

        $text = $handler->filterRequest($dbmodule, $route, $content);

        $data = [
            "content" => $content,
            "text" => $text,
        ];

        $this->app->page->add("blogg1/page", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function blogAction() : object
    {
        $title = "Bloggen blog";
        $handler = new BlogHandler();
        $dbmodule = $this->app->db;
        $res = $handler->selectRequest($dbmodule);

        $data = [
            "res" => $res,
        ];

        $this->app->page->add("blogg1/blog", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
    public function blogpostActionGet($route) : object
    {
        $title = "Bloggen $route";
        $handler = new BlogHandler();
        $dbmodule = $this->app->db;
        $content = $handler->blogGetRequest($dbmodule, $route);

        if (!$content) {
            return $this->app->response->redirect("blogg1/page404");
        }

        $text = $handler->filterRequest($dbmodule, $route, $content);

        $data = [
            "content" => $content,
            "text" => $text,
        ];

        $this->app->page->add("blogg1/blogpost", $data);

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
