<?php

namespace Tests\Feature\Services;

use App\Models\Game;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

#php artisan test --filter=GameControllerTest
class GameControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexIsReturningCorrectData()
    {
        //ARRANGE
        Game::factory()->count(3)->create();
        //ACT
        $response = $this->getJson('/api/games');
        //ASSERT
        $response->assertStatus(Response::HTTP_OK)
                    ->assertJsonCount(3)
                    ->assertJsonStructure([
                        '*' => [
                            'id',
                            'code',
                            'name',
                            'genre',
                            'price',
                            'created_at'
                        ]
                    ]);
    }

    public function testStoreIsSavingInDatabase()
    {
        //ARRANGE
        $gameData = [
            'name' =>  'Game Test',
            'genre' => 'rpg',
            'price' => 10,
        ];
        //ACT
        $response = $this->postJson('/api/games', $gameData);
        //ASSERT 
        $response->assertStatus(Response::HTTP_CREATED)
                    ->assertJson($gameData);
        
        $this->assertDatabaseHas('games', $gameData);
    }

    public function testShowHasCorrectFields()
    {
        //ARRANGE
        $game = Game::factory()->create();
        //ACT
        $response = $this->getJson("/api/games/{$game->id}");
        //ASSERT
        $response->assertStatus(Response::HTTP_OK)
                    ->assertJson([
                        'id'   => $game->id,
                        'name' => $game->name,
                        'genre' => $game->genre
                    ]);
    }

    public function testUpdateIsUpdatingGame()
    {
        //ARRANGE
        $game = Game::factory()->create();
        $gameUpdateData = [
            'name' =>  'Game Test',
            'genre' => 'rpg',
            'price' => 10,
        ];
        //ACT
        $response = $this->postJson("/api/games/{$game->id}", $gameUpdateData);
        //ASSERT
        $response->assertStatus(Response::HTTP_OK)
                    ->assertJson($gameUpdateData);
    }

    public function testDestroyIsDeletingFromDatabase()
    {
        //ARRANGE
        $game = Game::factory()->create();
        //ACT
        $response = $this->deleteJson("/api/games/{$game->id}");
        //ASSERT
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('games', $game->getAttributes());
    }
}
