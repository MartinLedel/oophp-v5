<?php

/**
 * Routes to ease testing.
 */
return [
    // Path where to mount the routes, is added to each route path.

    // All routes in order
    "routes" => [
        [
            "info" => "DiceController",
            "mount" => "dice1",
            "handler" => "\Macy\Dice\DiceController",
        ]
    ]
];
