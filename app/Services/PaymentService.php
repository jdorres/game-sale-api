<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Purchase;
use Carbon\Carbon;

class PaymentService
{
    private $gatewayService;
    private $paymentMethodService;

    public function __construct(GatewayService $gatewayService, PaymentMethodService $paymentMethodService)
    {
        $this->gatewayService = $gatewayService;
        $this->paymentMethodService = $paymentMethodService;
    }

    public function createPaymentByPurchase(Purchase $purchase, $paymentMethodType): Payment
    {
        //calculate value
        $amount = $this->calculatePaymentAmountByPurchase($purchase);

        //get default gateway
        $gateway = $this->gatewayService->getDefaultGateway();
        
        //get payment method id
        $paymentMethod = $this->paymentMethodService->getMethodIdByType($paymentMethodType);

        //payment data
        $paymentData = [
            'payment_method_id' => $paymentMethod->id,
            'purchase_id' => $purchase->id,
            'gateway_id' => $gateway->id,
            'amount' => $amount,
            'status' => 'pending',//TODO: implementar status
            'due_date' => Carbon::now()//TODO: corrigir o due_date
        ];

        $payment = Payment::create($paymentData);
        return $payment;
    }

    //TODO: esse método era privado, mudei pra poder testar
    public function calculatePaymentAmountByPurchase(Purchase $purchase): int
    {
        $price = 0;
        foreach($purchase->games as $game){
            $price += $game->price;
        }
        return $price;
    }
}