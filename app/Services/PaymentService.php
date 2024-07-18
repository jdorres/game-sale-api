<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Purchase;
use Carbon\Carbon;
use Ramsey\Uuid\Type\Integer;

class PaymentService
{
    private $gatewayService;
    private $paymentMethodService;

    public function __construct(GatewayService $gatewayService, PaymentMethodService $paymentMethodService)
    {
        $this->gatewayService = $gatewayService;
        $this->paymentMethodService = $paymentMethodService;
    }

    public function createPaymentByPurchase(Purchase $purchase, $paymentMethod): Payment
    {
        //calculate value
        $amount = $this->calculatePaymentAmountByPurchase($purchase);

        //get default gateway
        $gateway = $this->gatewayService->getDefaultGateway();
        
        //get payment method id
        $paymentMethod = $this->paymentMethodService->getMethodIdByType($paymentMethod);

        //payment data
        $paymentData = [
            'user_id' => $purchase->user->id, //TODO: remover, não deve haver user aqui
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

    private function calculatePaymentAmountByPurchase(Purchase $purchase): int
    {
        $price = 0;
        foreach($purchase->games as $game){
            $price += $game->price;
        }
        return $price;
    }
}