<?php

/**
 * Routes to ease testing.
 */
return [
    // Path where to mount the routes, is added to each route path.

    // All routes in order
    "routes" => [
        [
            "info" => "MovieController",
            "mount" => "movie1",
            "handler" => "\Macy\Movie\MovieController",
        ]
    ]
];
