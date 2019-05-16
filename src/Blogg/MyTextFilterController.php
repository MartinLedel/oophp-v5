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
class MyTextFilterController implements AppInjectableInterface
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

    public function bbcodeAction() : object
    {
        $title = "bbcode";
        $filterclass = new MyTextFilter();
        $filter = ["bbcode"];
        $text = file_get_contents(ANAX_INSTALL_PATH . "/htdocs/text/bbcode.txt");
        $html = $filterclass->parse($text, $filter);

        $data = [
            "text" => $text,
            "html" => $html,
        ];

        $this->app->page->add("mytext/bbcode", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);

        return $this->app->response->redirect("mytext/bbcode");
    }
    public function clickableAction() : object
    {
        $title = "clickable";
        $filterclass = new MyTextFilter();
        $filter = ["link"];
        $text = file_get_contents(ANAX_INSTALL_PATH . "/htdocs/text/clickable.txt");
        $html = $filterclass->parse($text, $filter);

        $data = [
            "text" => $text,
            "html" => $html,
        ];

        $this->app->page->add("mytext/clickable", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);

        return $this->app->response->redirect("mytext/clickable");
    }
    public function markdownAction() : object
    {
        $title = "markdown";
        $filterclass = new MyTextFilter();
        $filter = ["markdown"];
        $text = file_get_contents(ANAX_INSTALL_PATH . "/htdocs/text/sample.md");
        $html = $filterclass->parse($text, $filter);

        $data = [
            "text" => $text,
            "html" => $html,
        ];

        $this->app->page->add("mytext/markdown", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);

        return $this->app->response->redirect("mytext/markdown");
    }
}
