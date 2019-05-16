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
    use AppInjectableTrait;

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
        $title = "Bloggen";

        $res = "test";
        
        $data = [
            "res" => $res,
        ];

        $this->app->page->add("blogg1/index", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
    }
}
