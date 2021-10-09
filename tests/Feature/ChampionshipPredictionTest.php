<?php

namespace Tests\Feature;

use App\Layers\Data\GameData;
use App\Layers\Service\GameService;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use function Symfony\Component\String\s;

class ChampionshipPredictionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_percentagesSum()
    {
        $gameData = new GameData();
        $gameService = new GameService($gameData);

        $teams = Team::factory()->count(4)->create();
        for ($i=0; $i<10; $i++){
            $gameService->generateFixture();

            for ($j=1; $j<=6; $j++){
                $gameService->play();
                $predictions = $gameService->getPredictions();
                if ($j<=2){
                    // all percentages = "-"
                    foreach ($predictions as $prediction)
                    {
                        self::assertEquals("-", $prediction);
                    }
                }else{
                    $sum = 0;
                    // sum percentage = 100
                    foreach ($predictions as $prediction)
                    {
                        $sum += $prediction;
                    }
                    self::assertEquals(100, round($sum));
                }
            }

            $gameService->reset();
        }
    }
}
