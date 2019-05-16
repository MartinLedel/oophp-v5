<?php

namespace Macy\Movie;

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
class MovieController implements AppInjectableInterface
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
        $title = "Movie database";

        $this->app->db->connect();
        $sql = "SELECT * FROM movie;";
        $res = $this->app->db->executeFetchAll($sql);

        $data = [
            "res" => $res,
        ];

        $this->app->page->add("movie1/index", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);

        return $this->app->response->redirect("movie1/index");
    }

    public function searchTitleAction() : object
    {
        $title = "Movie database search";
        //Handle session
        $searchTitle = $this->app->request->getGet("searchTitle");

        if ($this->app->request->getGet("doSearch")) {
            $this->app->db->connect();
            $sql = "SELECT * FROM movie WHERE title LIKE ?;";
            $res = $this->app->db->executeFetchAll($sql, [$searchTitle]);
        } else {
            $this->app->db->connect();
            $sql = "SELECT * FROM movie;";
            $res = $this->app->db->executeFetchAll($sql);
        }

        $data = [
            "res" => $res,
            "searchTitle" => $searchTitle,
        ];

        $this->app->page->add("movie1/search-title", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
        return $this->app->response->redirect("movie1/search-title");
    }
    public function searchYearAction() : object
    {
        $title = "Movie database search";
        //Handle session
        $year1 = $this->app->request->getGet("year1");
        $year2 = $this->app->request->getGet("year2");

        if ($this->app->request->getGet("doSearch")) {
            if ($year1 && $year2) {
                $this->app->db->connect();
                $sql = "SELECT * FROM movie WHERE year >= ? AND year <= ?;";
                $res = $this->app->db->executeFetchAll($sql, [$year1, $year2]);
            } elseif ($year1) {
                $this->app->db->connect();
                $sql = "SELECT * FROM movie WHERE year >= ?;";
                $res = $this->app->db->executeFetchAll($sql, [$year1]);
            } elseif ($year2) {
                $this->app->db->connect();
                $sql = "SELECT * FROM movie WHERE year <= ?;";
                $res = $this->app->db->executeFetchAll($sql, [$year2]);
            }
        } else {
            $this->app->db->connect();
            $sql = "SELECT * FROM movie;";
            $res = $this->app->db->executeFetchAll($sql);
        }

        $data = [
            "res" => $res,
            "year1" => $year1,
            "year2" => $year2,
        ];

        $this->app->page->add("movie1/search-year", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);
        return $this->app->response->redirect("movie1/search-year");
    }
    public function editAction() : object
    {
        $title = "Movie database edit";
        $movieId = $this->app->request->getGet("movieId");
        $movieId2 = $this->app->session->get("movieId", $movieId);

        if ($movieId && is_numeric($movieId)) {
            $movieId++;
            $this->app->db->connect();
            $sql = "SELECT * FROM movie WHERE id = $movieId;";
            $movie = $this->app->db->executeFetchAll($sql);
        } elseif ($movieId2 && is_numeric($movieId2)) {
            $this->app->db->connect();
            $sql = "SELECT * FROM movie WHERE id = $movieId2;";
            $movie = $this->app->db->executeFetchAll($sql);
        } else {
            $movie = $this->app->session->get("movie");
        }

        $data = [
            "movie" => $movie[0],
        ];

        $this->app->page->add("movie1/edit", $data);
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);

        return $this->app->response->redirect("movie1/edit");
    }
    public function editActionPost() : object
    {
        $movieId = $this->app->request->getPost("movieId");
        $movieTitle = $this->app->request->getPost("movieTitle");
        $movieYear = $this->app->request->getPost("movieYear");
        $movieImage = $this->app->request->getPost("movieImage");

        if ($this->app->request->getPost("doSave")) {
            $this->app->db->connect();
            $sql = "UPDATE movie SET title = ?, year = ?, image = ? WHERE id = ?;";
            $this->app->db->execute($sql, [$movieTitle, $movieYear, $movieImage, $movieId]);
            $this->app->session->set("movieId", $movieId);
        } else {
            $this->app->db->connect();
            $sql = "SELECT * FROM movie WHERE id = $movieId;";
            $movie = $this->app->db->executeFetchAll($sql);
            $this->app->session->set("movie", $movie);
        }

        return $this->app->response->redirect("movie1/edit");
    }
    public function addAction() : object
    {
        $title = "Movie database add";

        $this->app->page->add("movie1/add");
        // $this->app->page->add("dice1/debug");

        return $this->app->page->render([
            "title" => $title,
        ]);

        return $this->app->response->redirect("movie1/add");
    }
    public function addActionPost() : object
    {
        $movieTitle = $this->app->request->getPost("movieTitle");
        $movieYear = $this->app->request->getPost("movieYear");
        $movieImage = $this->app->request->getPost("movieImage");

        if ($this->app->request->getPost("doAdd")) {
            $this->app->db->connect();
            $sql = "INSERT INTO movie (title, year, image) VALUES (?, ?, ?);";
            $this->app->db->execute($sql, [$movieTitle, $movieYear, $movieImage]);
        }

        return $this->app->response->redirect("movie1/index");
    }
    public function deleteAction() : object
    {
        $movieId = $this->app->request->getGet("movieId");

        if ($movieId && is_numeric($movieId)) {
            $movieId++;
            $this->app->db->connect();
            $sql = "DELETE FROM movie WHERE id = ?;";
            $this->app->db->execute($sql, [$movieId]);
        }

        return $this->app->response->redirect("movie1/index");
    }
}
