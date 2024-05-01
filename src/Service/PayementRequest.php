<?php
namespace App\Service;

class PaymentRequest
{
    private $receiverWalletId;
    private $amount;

    public function __construct(string $receiverWalletId, float $amount)
    {
        $this->receiverWalletId = $receiverWalletId;
        $this->amount = $amount;
    }
}