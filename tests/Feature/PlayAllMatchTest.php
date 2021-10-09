<?php

namespace Tests\Feature;

use App\Layers\Data\GameData;
use App\Layers\Service\GameService;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PlayAllMatchTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_playAllMatchTest()
    {
        Team::factory()->count(4)->create();

        $gameData = new GameData();
        $gameService = new GameService($gameData);
        $gameService->generateFixture();

        $gameService->playAll();

        $this->assertDatabaseMissing("games", [
            "played" => false
        ]);
    }
}
