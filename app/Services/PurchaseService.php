<?php

namespace App\Services;

use App\Models\Purchase;

class PurchaseService
{
    private $paymentService;
    private $gameService;
    public function __construct(GameService $gameService, PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
        $this->gameService = $gameService;
    }

    public function store(array $data):Purchase
    {
        $purchase = Purchase::create($data);
        $this->gameService->linkGamesToPurchase($purchase, $data['games']);
        $this->paymentService->createPaymentByPurchase($purchase, $data['payment_method'], $data['payment_method']);
        return $purchase;
    }
}