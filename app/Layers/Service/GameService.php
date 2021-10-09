<?php

namespace App\Layers\Service;

use App\Helpers\SimulationHelper;
use App\Layers\Data\IGameData;
use Illuminate\Support\Facades\Log;

class GameService implements IGameService
{
    private IGameData $gameData;

    public function __construct(IGameData $gameData)
    {
        $this->gameData = $gameData;
    }

    public function getLastWeekGames()
    {
        $lastTwoPlayed = $this->gameData->getLastTwoPlayed();

        if (count($lastTwoPlayed) == 0)
            $lastTwoPlayed = $this->gameData->getFirstTwoNotPlayed();

        return $lastTwoPlayed;
    }

    public function play()
    {
        $firstTwoNotPlayedGames = $this->gameData->getFirstTwoNotPlayed();
        if (count($firstTwoNotPlayedGames) == 0)
            return false;

        $pointTable = SimulationHelper::getPointTable();

        foreach ($firstTwoNotPlayedGames as $game)
        {
            $team1Index = array_search($game->team_1, array_column($pointTable, 'team'));
            $team2Index = array_search($game->team_2, array_column($pointTable, 'team'));

            $team1Goals = $this->getGoalNumber($pointTable[$team1Index], $pointTable[$team2Index]);
            $team2Goals = $this->getGoalNumber($pointTable[$team2Index], $pointTable[$team1Index]);

            $game->score_1 = $team1Goals;
            $game->score_2 = $team2Goals;
            $game->played = true;
            $response = $this->gameData->update($game);
            if (!$response)
                Log::error("Play Method Error, Game not saved");
        }

        return true;
    }

    private function getGoalNumber($for, $against){
        $goals = 0;
        $coefficient1 = $for["w"] - $for["l"] - $against["w"] + $against["l"] + $for["gd"];
        if ($coefficient1 > 0){
            $goals += rand(0, $coefficient1 % 3);
        }
        $goals += rand(0, rand(1,6));

        return $goals;
    }

    public function reset()
    {
        return $this->gameData->deleteAll();
    }

    public function playAll()
    {
        $res = true;
        while ($res)
            $res = $this->play();
    }

    public function getPlayedGames()
    {
        return $this->gameData->getPlayedGames();
    }

    // todo: calculate prediction and logic
    public function getPredictions()
    {
        $predictions = [];
        $teams = $this->gameData->getMatchTeams();
        foreach ($teams as $team)
        {
            $predictions[$team->team_1] = "-";
        }

        // calculate prediction for each team
        $pointTable = SimulationHelper::getPointTable();
        $remainingWeekNumber = $this->gameData->remainingWeekNumber();
        if ($remainingWeekNumber > 3){
            return $predictions;
        }

        // last 3 weeks check
        // if in last 3 week, check %100 case, if first_team_score - second_team_score > 9 then championship team = first_team
        // if in last 2 week, check %100 case, if first_team_score - second_team_score > 6 then championship team = first_team
        // if in last 1 week, check %100 case, if first_team_score - second_team_score > 3 then championship team = first_team
        // $remainingWeekNumber == 0 => %100 championship team = first_team
        if (($remainingWeekNumber < 3 && $pointTable[0]["pts"] - $pointTable[1]["pts"] > $remainingWeekNumber*3) || $remainingWeekNumber == 0){
            $predictions[$pointTable[0]["team"]] = 100;
            $predictions[$pointTable[1]["team"]] = 0;
            $predictions[$pointTable[2]["team"]] = 0;
            $predictions[$pointTable[3]["team"]] = 0;
            return $predictions;
        }

        foreach ($pointTable as $row){
            if ($pointTable[0]["pts"] - $row["pts"] > $remainingWeekNumber * 3)
                $predictions[$row["team"]] = 0;
        }

        $remainingPercentage = 100;
        $stakeHolder = 0;

        // calculate remaining stakeholders
        foreach ($pointTable as $item)
        {
            $coefficient = $item["w"] + ($item["gd"] / 7);
            if ($coefficient == 0){
                $coefficient = 0.25;
            }
            if ($predictions[$item["team"]] != 0){
                $stakeHolder += $coefficient;
            }
        }

        // divide percentages between remaining stakeholders
        foreach ($pointTable as $item)
        {
            $coefficient = $item["w"] + ($item["gd"] / 7);
            if ($coefficient == 0){
                $coefficient = 0.25;
            }
            if ($predictions[$item["team"]] == "-"){
                $predictions[$item["team"]] = number_format($remainingPercentage / $stakeHolder * $coefficient, 1);
            }
        }

        return $predictions;
    }
}
