<?php

namespace App\Layers\Data;

use App\Models\Game;

interface IGameData
{
    public function getFirstTwoNotPlayed();

    public function update(Game $game): bool;

    public function getLastTwoPlayed();

    public function deleteAll();

    public function getPlayedGames();

    public function getMatchTeams();

    public function getPlayedGamesByTeam($teamName);

    public function remainingWeekNumber();

    public function getGamesByWeek($week);

    public function getAnyGame();

    public function save($team_1, $team_2, $week): bool;

    public function getPlayedGamesByTeam1($team1);

    public function getPlayedGamesByTeam2($team2);
}
