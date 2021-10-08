<?php

namespace App\Helpers;

use App\Models\Game;
use App\Models\Team;

class SimulationHelper
{
    public static function getPointTable(): array
    {
        $teams = Team::all();

        $pointTable = [];
        foreach ($teams as $team) {
            $pts = 0;
            $p = 0;
            $w = 0;
            $d = 0;
            $l = 0;
            $gd = 0;

            // games that played as home team
            $homeGames = Game::where('played', true)->where('team_1', $team->name)->get();
            foreach ($homeGames as $game) {
                $p++;
                if ($game->score_1 > $game->score_2) {$w++; $pts += 3;}
                elseif ($game->score_1 == $game->score_2) {$d++; $pts += 1;}
                else $l++;
            }

            // games that played as guest team
            $guestGames = Game::where('played', true)->where('team_2', $team->name)->get();
            foreach ($guestGames as $game) {
                $p++;
                if ($game->score_1 < $game->score_2) {$w++; $pts += 3;}
                elseif ($game->score_1 == $game->score_2) {$d++; $pts += 1;}
                else $l++;
            }

            array_push($pointTable, [
                "team" => $team->name,
                "pts" => $pts,
                "p" => $p,
                "w" => $w,
                "d" => $d,
                "l" => $l,
                "gd" => $gd,
            ]);
        }

        return $pointTable;
    }
}
