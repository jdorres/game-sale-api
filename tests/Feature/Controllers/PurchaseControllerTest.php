<?php

namespace Tests\Feature\Services;

use App\Models\Game;
use App\Models\Gateway;
use App\Models\PaymentMethod;
use App\Models\Purchase;
use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;

#php artisan test --filter=PurchaseControllerTest
class PurchaseControllerTest extends TestCase
{
    use RefreshDatabase;

    public function testIndexIsReturningCorrectData()
    {
        //ARRANGE
        User::factory()->create();
        Purchase::factory()->count(3)->create();
        //ACT
        $response = $this->getJson('api/purchases');
        //ASSERT
        $response->assertStatus(Response::HTTP_OK)
                    ->assertJsonStructure([
                        '*' => [
                            'id',
                            'user',
                            'games',
                            'payments',
                            'created_at'
                        ]
                    ]);
    }

    public function testStoreIsSavingInDatabase()
    {
        //ARRANGE
        $user = User::factory()->create();
        $game1 = Game::factory()->create();
        $game2 = Game::factory()->create();
        $paymentMethod = PaymentMethod::factory()->create();
        Gateway::factory()->create();
        $purchaseData = [
            'user_id' => $user->id,
            'payment_method' => $paymentMethod->type,
            'games' => [
                $game1->code,
                $game2->code
            ]
        ];
        //ACT
        $response = $this->postJson('api/purchases', $purchaseData);
        //ASSERT
        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function testShowHasCorrectFields()
    {
        User::factory()->create();
        PaymentMethod::factory()->create();
        $purchase = Purchase::factory()->create();

        $response = $this->getJson("api/purchases/{$purchase->id}");

        $response->assertStatus(Response::HTTP_OK)
                    ->assertJsonStructure([
                        'id',
                        'user',
                        'games',
                        'payments',
                        'created_at'
                    ]);
    }

    public function testUpdateIsUpdatingPurchase()
    {
        User::factory()->create();
        PaymentMethod::factory()->create();
        $purchase = Purchase::factory()->create();

        $newUser = User::factory()->create();
        $purchaseUpdateData = [
            'user_id' => $newUser->id
        ];
        
        $response = $this->postJson("api/purchases/{$purchase->id}", $purchaseUpdateData);

        $response->assertStatus(Response::HTTP_OK)
                    ->assertJson($purchaseUpdateData);
    }

    public function testDestroyIsDeletingFromDatabase()
    {
        User::factory()->create();
        PaymentMethod::factory()->create();
        $purchase = Purchase::factory()->create();
        $response = $this->deleteJson("api/purchases/{$purchase->id}");
        $response->assertStatus(Response::HTTP_OK);
        $this->assertDatabaseMissing('games', $purchase->getAttributes());
    }
}
