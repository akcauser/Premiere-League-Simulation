<?php

namespace App\Layers\Data;

use App\Models\Game;
use Illuminate\Support\Facades\DB;

class GameData implements IGameData
{
    /**
     * @return mixed
     */
    public function getFirstTwoNotPlayed()
    {
        return Game::where('played', false)->limit(2)->orderBy('week')->get();
    }

    /**
     * @param Game $game
     * @return bool
     */
    public function update(Game $game): bool
    {
        return $game->save();
    }

    /**
     * @return mixed
     */
    public function getLastTwoPlayed()
    {
        return Game::where('played', true)->limit(2)->orderBy('week', 'desc')->get();
    }

    public function deleteAll(): int
    {
        return DB::table('games')->delete();
    }

    /**
     * @return mixed
     */
    public function getPlayedGames()
    {
        return Game::where('played', true)->orderBy('week')->get();
    }

    /**
     * @return mixed
     */
    public function getMatchTeams()
    {
        return Game::select('team_1')->groupBy('team_1')->orderBy('team_1')->get();
    }

    /**
     * @param $teamName
     * @return mixed
     */
    public function getPlayedGamesByTeam($teamName)
    {
        return Game::where('played', true)->orWhere(function ($query) use ($teamName){
            $query->where('team_1', $teamName);
            $query->where('team_2', $teamName);
        })->get();
    }

    /**
     * @return int
     */
    public function remainingWeekNumber(): int
    {
        $nextFirstMatch = Game::where('played', false)->orderBy('week')->first();
        if (!isset($nextFirstMatch))
            return 0;
        return 7 - $nextFirstMatch->week;
    }

    /**
     * @param $week
     * @return mixed
     */
    public function getGamesByWeek($week)
    {
        return Game::where('week', $week)->get();
    }

    /**
     * @return mixed
     */
    public function getAnyGame()
    {
        return Game::limit(1)->get();
    }

    /**
     * @param $team_1
     * @param $team_2
     * @param $week
     * @return bool
     */
    public function save($team_1, $team_2, $week): bool
    {
        $game = new Game;
        $game->team_1 = $team_1;
        $game->team_2 = $team_2;
        $game->week = $week;
        return $game->save();
    }

    /**
     * @param $team1
     * @return mixed
     */
    public function getPlayedGamesByTeam1($team1)
    {
        return Game::where('played', true)->where('team_1', $team1)->get();
    }

    /**
     * @param $team2
     * @return mixed
     */
    public function getPlayedGamesByTeam2($team2)
    {
        return Game::where('played', true)->where('team_2', $team2)->get();
    }

    /**
     * @param $team1
     * @return mixed
     */
    public function getNotPlayedGamesByTeam1($team1)
    {
        return Game::where('played', false)->where('team_1', $team1)->get();
    }

    /**
     * @param $team2
     * @return mixed
     */
    public function getNotPlayedGamesByTeam2($team2)
    {
        return Game::where('played', false)->where('team_2', $team2)->get();
    }
}
