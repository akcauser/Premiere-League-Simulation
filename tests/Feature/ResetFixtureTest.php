<?php

namespace Tests\Feature;

use App\Layers\Data\GameData;
use App\Layers\Service\GameService;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResetFixtureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_resetFixture()
    {
        Team::factory()->count(4)->create();
        $gameData = new GameData();
        $gameService = new GameService($gameData);
        $gameService->generateFixture();

        $gameService->reset();
        $this->assertDatabaseCount("games", 0);
    }
}
