<?php

namespace App\Layers\Service;

use App\Helpers\FixtureHelper;
use App\Layers\Data\IGameData;
use App\Models\Team;
use Illuminate\Support\Facades\Log;

class GameService implements IGameService
{
    private $gameData;

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

        $pointTable = $this->getPointTable();

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
        $pointTable = $this->getPointTable();
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
            $coefficient = $item["w"] + ($item["gd"] / 7 > 0 ? $item["gd"] / 7 : 0);
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
            $coefficient = $item["w"] + ($item["gd"] / 7 > 0 ? $item["gd"] / 7 : 0);
            if ($coefficient == 0){
                $coefficient = 0.25;
            }
            if ($predictions[$item["team"]] == "-"){
                $predictions[$item["team"]] = number_format($remainingPercentage / $stakeHolder * $coefficient, 2);
            }
        }

        return $predictions;
    }

    public function getFixture()
    {
        $fixture = [];
        for ($i=1; $i<=6; $i++){
            $games = $this->gameData->getGamesByWeek($i);
            $fixture["Week $i"] = $games;
        }

        return $fixture;
    }

    public function checkFixtureCreated(): bool
    {
        $data = $this->gameData->getAnyGame();
        if (count($data) == 1){
            return true;
        }

        return false;
    }

    public function generateFixture(): bool
    {
        $teams = Team::all()->toArray();
        shuffle($teams);
        foreach (FixtureHelper::$fixtureDesign as $weekNumber => $week) {
            $this->gameData->save(
                $teams[$week[0][0]-1]["name"],
                $teams[$week[0][1]-1]["name"],
                $weekNumber
            );

            $this->gameData->save(
                $teams[$week[1][0]-1]["name"],
                $teams[$week[1][1]-1]["name"],
                $weekNumber
            );
        }

        return true;
    }

    public function getPointTable(): array
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
            $homeGames = $this->gameData->getPlayedGamesByTeam1($team->name);
            foreach ($homeGames as $game) {
                $p++;
                if ($game->score_1 > $game->score_2) {$w++; $pts += 3;}
                elseif ($game->score_1 == $game->score_2) {$d++; $pts += 1;}
                else $l++;

                $gf += $game->score_1;
                $ga += $game->score_2;
            }

            // games that played as guest team
            $guestGames = $this->gameData->getPlayedGamesByTeam2($team->name);
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
