<?php

namespace Tests\Feature;

use App\Layers\Data\GameData;
use App\Layers\Service\GameService;
use App\Layers\Service\IGameService;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FixtureGenerateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_generateFixture()
    {
        $teams = Team::factory()->count(4)->create();

        $gameData = new GameData();
        $gameService = new GameService($gameData);
        $gameService->generateFixture();

        $this->assertDatabaseCount("games", 12);

        foreach ($teams as $team){
            $this->assertCount(3, $gameData->getNotPlayedGamesByTeam1($team->name));
            $this->assertCount(3, $gameData->getNotPlayedGamesByTeam2($team->name));
        }
    }
}
