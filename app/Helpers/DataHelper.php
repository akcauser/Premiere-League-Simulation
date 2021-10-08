<?php

namespace App\Helpers;

class DataHelper
{
    public static $teams = ["Liverpool", "Manchester City", "Chelsea", "Arsenal"];

    // Fixture design for six weeks and four teams
    public static $fixtureDesign = [
        "Week 1" => [
            [1, 2],
            [3, 4],
        ],
        "Week 2" => [
            [3, 1],
            [4, 2],
        ],
        "Week 3" => [
            [1, 4],
            [2, 3],
        ],
        "Week 4" => [
            [2, 1],
            [4, 3],
        ],
        "Week 5" => [
            [1, 3],
            [2, 4],
        ],
        "Week 6" => [
            [4, 1],
            [3, 2],
        ],
    ];
}
