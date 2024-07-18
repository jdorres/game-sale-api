<?php

namespace App\Services;

use App\Models\Gateway;

class GatewayService
{
    public function getDefaultGateway():Gateway
    {
        //TODO como vou definir o gateways default?
        $gateway = Gateway::where('default', true)->first();
        return $gateway;
    }
}