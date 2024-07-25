<?php

namespace Tests\Feature\Services;

use App\Models\Game;
use App\Models\Gateway;
use App\Models\PaymentMethod;
use App\Models\Purchase;
use App\Models\User;
use App\Services\GameService;
use App\Services\GatewayService;
use App\Services\PaymentMethodService;
use App\Services\PaymentService;
use App\Services\PurchaseService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

#php artisan test --filter=PurchaseServiceTest
class PurchaseServiceTest extends TestCase
{
    use RefreshDatabase;
    protected $purchaseService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->purchaseService = new PurchaseService(
            new GameService, 
            new PaymentService(
                new GatewayService, 
                new PaymentMethodService
            )
        );
    }

    public function testStore()
    {
        //ARRANGE
        Gateway::factory()->create();
        $user = User::factory()->create();
        $payment = PaymentMethod::factory()->create();
        $game1 = Game::factory()->create();
        $game2 = Game::factory()->create();
        $data = [
            "user_id" => $user->id,
            "payment_method" => $payment->type,
            "games"=> [
                $game1->code,
                $game2->code
            ]
        ];

        //ACT
        $purchase = $this->purchaseService->store($data);

        //ASSERT
        //verificar se a purchase foi criada
        //verificar se a purchase está vinculada aos jogos?
        $this->assertInstanceOf(Purchase::class, $purchase);
        $this->assertCount(expectedCount: 2, haystack: $purchase->games);

    }
}
