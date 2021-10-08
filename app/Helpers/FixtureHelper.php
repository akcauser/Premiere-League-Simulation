<?php

namespace App\Helpers;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Support\Facades\DB;

class FixtureHelper
{
    public static $teams = ["Liverpool", "Manchester City", "Chelsea", "Arsenal"];

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

    public static function generateFixture(): bool
    {
        $teams = Team::all()->toArray();
        shuffle($teams);
        foreach (FixtureHelper::$fixtureDesign as $weekNumber => $week) {
            $game1 = new Game;
            $game1->team_1 = $teams[$week[0][0]-1]["name"];
            $game1->team_2 = $teams[$week[0][1]-1]["name"];
            $game1->week = $weekNumber;
            $game1->save();

            $game2 = new Game;
            $game2->team_1 = $teams[$week[1][0]-1]["name"];
            $game2->team_2 = $teams[$week[1][1]-1]["name"];
            $game2->week = $weekNumber;
            $game2->save();
        }

        return true;
    }

    public static function checkFixtureCreated(): bool
    {
        $data = DB::table('games')->limit(1)->get();
        if (count($data) == 1){
            return true;
        }

        return false;
    }

    public static function getFixture(): array
    {
        $fixture = [];
        for ($i=1; $i<=6; $i++){
            $games = Game::where('week', $i)->get();
            $fixture["Week $i"] = $games;
        }

        return $fixture;
    }
}
