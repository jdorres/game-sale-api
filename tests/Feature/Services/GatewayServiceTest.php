<?php

namespace Tests\Feature\Services;

use App\Models\Gateway;
use App\Services\GatewayService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

#php artisan test --filter=GatewayServiceTest
class GatewayServiceTest extends TestCase
{
    use RefreshDatabase;
    protected $gatewayService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gatewayService = new GatewayService;
    }

    public function testGetDefaultGateway()
    {
        //ARRANGE
        Gateway::factory()->create();

        //ACT
        $gateway = $this->gatewayService->getDefaultGateway();

        //ASSERT
        $this->assertTrue((bool) $gateway->is_default);
    }
}
