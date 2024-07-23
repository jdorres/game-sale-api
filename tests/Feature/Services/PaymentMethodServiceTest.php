<?php

namespace Tests\Feature\Services;

use App\Models\Gateway;
use App\Models\PaymentMethod;
use App\Services\PaymentMethodService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

#php artisan test --filter=PaymentMethodServiceTest
class PaymentMethodServiceTest extends TestCase
{
    use RefreshDatabase;
    protected $paymentMethodService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->paymentMethodService = new PaymentMethodService;
    }

    public function testgetMethodIdByType()
    {
        //ARRANGE
        PaymentMethod::factory()->create();
        $type = 'pix';
        //ACT
        $paymentMethod = $this->paymentMethodService->getMethodIdByType($type);
        //ASSERT
        $this->assertEquals($paymentMethod->type, $type);
    }
}
