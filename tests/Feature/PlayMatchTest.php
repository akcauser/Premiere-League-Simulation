<?php

namespace Tests\Feature;

use App\Layers\Data\GameData;
use App\Layers\Service\GameService;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayMatchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_playMatch()
    {
        Team::factory()->count(4)->create();

        $gameData = new GameData();
        $gameService = new GameService($gameData);
        $gameService->generateFixture();

        $gamesNotPlayed = $gameData->getFirstTwoNotPlayed();

        $gamesPlayed = [];
        foreach ($gamesNotPlayed as $game) {
            array_push($gamesPlayed, [
                "id" => $game->id,
                "team_1" => $game->team_1,
                "team_2" => $game->team_2,
                "played" => true,
            ]);
        }

        $gameService->play();

        $this->assertDatabaseHas("games", $gamesPlayed[0]);
        $this->assertDatabaseHas("games", $gamesPlayed[1]);
    }
}
