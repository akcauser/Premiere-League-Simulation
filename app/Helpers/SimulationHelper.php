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
            $pts = 0; // point
            $p = 0; // played
            $w = 0; // won
            $d = 0; // drawn
            $l = 0; // lost
            $gf = 0; // goal scored
            $ga = 0; // goal conceded

            // games that played as home team
            $homeGames = Game::where('played', true)->where('team_1', $team->name)->get();
            foreach ($homeGames as $game) {
                $p++;
                if ($game->score_1 > $game->score_2) {$w++; $pts += 3;}
                elseif ($game->score_1 == $game->score_2) {$d++; $pts += 1;}
                else $l++;

                $gf += $game->score_1;
                $ga += $game->score_2;
            }

            // games that played as guest team
            $guestGames = Game::where('played', true)->where('team_2', $team->name)->get();
            foreach ($guestGames as $game) {
                $p++;
                if ($game->score_1 < $game->score_2) {$w++; $pts += 3;}
                elseif ($game->score_1 == $game->score_2) {$d++; $pts += 1;}
                else $l++;

                $gf += $game->score_2;
                $ga += $game->score_1;
            }

            $gd = $gf-$ga;

            array_push($pointTable, [
                "team" => $team->name,
                "pts" => $pts,
                "p" => $p,
                "w" => $w,
                "d" => $d,
                "l" => $l,
                "gd" => $gd,
                "gf" => $gf,
                "ga" => $ga,
            ]);
        }

        // sort point table with pts
        usort($pointTable, function($a, $b) {
            if ($a['pts'] == $b['pts']) {
                return $b['gd'] - $a['gd'];
            }
            return $b['pts'] - $a['pts'];
        });

        return $pointTable;
    }



}
