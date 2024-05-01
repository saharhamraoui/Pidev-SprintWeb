<?php
namespace App\Response;

class PaymentResponse
{
    private $payUrl;
    private $paymentRef;

    public function __construct(string $payUrl, string $paymentRef)
    {
        $this->payUrl = $payUrl;
        $this->paymentRef = $paymentRef;
    }
}