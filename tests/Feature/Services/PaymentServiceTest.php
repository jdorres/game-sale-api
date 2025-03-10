<?php

namespace Tests\Feature\Services;

use App\Models\Game;
use App\Models\Gateway;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Purchase;
use App\Models\User;
use App\Services\GatewayService;
use App\Services\PaymentMethodService;
use App\Services\PaymentService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

#php artisan test --filter=PaymentServiceTest
class PaymentServiceTest extends TestCase
{
    use RefreshDatabase;
    protected $paymentService;

    protected function setUp(): void
    {
        parent::setup();
        //TODO: como lidar corretamente com essas injeções de dependências?
        $this->paymentService = new PaymentService(new GatewayService, new PaymentMethodService);
    }

    public function testCreatePaymentByPurchase()
    {
        //ARRANGE
        User::factory()->create();
        $purchase = Purchase::factory()->create();
        $paymentMethodType = PaymentMethod::factory()->create()->type;
        Gateway::factory()->create();

        //ACT
        $payment = $this->paymentService->createPaymentByPurchase($purchase, $paymentMethodType);
        
        //ASSERT
        //TODO: seria interessante fazer vários asserts em um só método?
        //testar se retorna um pagamento?
        //testar algum campo amount? status? alguma relation?
        $this->assertInstanceOf(Payment::class, $payment);
    }

    public function testCalculatePaymentAmountByPurchase()
    {
        //ARRANGE
        User::factory()->create();
        $purchase = Purchase::factory()->create();
        
        $priceToAssert = 0;
        $game = Game::factory()->create();
        $priceToAssert += $game->price;
        $purchase->games()->attach($game);

        $game = Game::factory()->create();
        $priceToAssert += $game->price;
        $purchase->games()->attach($game);

        $game = Game::factory()->create();
        $priceToAssert += $game->price;
        $purchase->games()->attach($game);

        //ACT
        $totalPrice = $this->paymentService->calculatePaymentAmountByPurchase($purchase);

        //ASSERT
        $this->assertEquals($priceToAssert, $totalPrice);
    }
}
