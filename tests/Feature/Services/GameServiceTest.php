<?php

namespace Tests\Feature\Services;

use App\Models\Game;
use App\Models\Purchase;
use App\Models\User;
use App\Services\GameService;
use Exception;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

#php artisan test --filter=GameServiceTest
class GameServiceTest extends TestCase
{
    use RefreshDatabase;
    protected $gameService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gameService = new GameService;
    }

    public function testLinkGamesToPurchase(): void
    {
        //TODO: vai usar banco de dados?
        //TODO: o save deveria estar dentro do método linkGamesToPurchase?
        
        //ARRANGE
        //instaciar user
        $user = User::factory()->create();

        //instaciar purchase
        $purchase = Purchase::factory()->create();
        
        //criar lista de jogos
        $games = Game::factory()->count(3)->create();
        $gameCodes = [];
        foreach($games as $game){
            $gameCodes [] = $game->code;
        }

        //ACT
        //chama o método testado
        $returnedPurchase = $this->gameService->linkGamesToPurchase($purchase, $gameCodes);
        
        //ASSERT
        //verifica se o purchase foi retornado com a lista de jogos correta

        $this->assertCount(expectedCount: 3, haystack: $returnedPurchase->games);
    }

    public function testLinkGamesToPurchaseThrowExceptionWhenGameNotFound(): void
    {
        //TODO: vai usar banco de dados?
        //TODO: o save deveria estar dentro do método linkGamesToPurchase?
        
        //ARRANGE
        //instaciar user
        $user = User::factory()->create();

        //instaciar purchase
        $purchase = Purchase::factory()->create();
        
        //criar lista de jogos com jogo que não existe
        $gameCodes = ['23c2c23c23c'];

        //ACT
        //chama o método testado

        $testFunction = function() use($purchase, $gameCodes) {
            $this->gameService->linkGamesToPurchase($purchase, $gameCodes);
        };
        
        //ASSERT
        //verifica se o purchase foi retornado com a lista de jogos correta

        $this->assertThrows($testFunction, Exception::class, 'Game not found!');

    }
}
