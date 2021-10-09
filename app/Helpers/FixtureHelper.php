<?php

namespace App\Helpers;

class FixtureHelper
{
    // Fixture design for six weeks and four teams
    public static $fixtureDesign = [
        1 => [
            [1, 2],
            [3, 4],
        ],
        2 => [
            [3, 1],
            [4, 2],
        ],
        3 => [
            [1, 4],
            [2, 3],
        ],
        4 => [
            [2, 1],
            [4, 3],
        ],
        5 => [
            [1, 3],
            [2, 4],
        ],
        6 => [
            [4, 1],
            [3, 2],
        ],
    ];
}
