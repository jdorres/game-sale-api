<?php

namespace App\Services;

use App\Models\PaymentMethod;

class PaymentMethodService
{
    public function getMethodIdByType($type):PaymentMethod
    {
        $paymentMethod = PaymentMethod::where('type', $type)->first();
        return $paymentMethod;
    }
}