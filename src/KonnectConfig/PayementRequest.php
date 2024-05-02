<?php
namespace App\KonnectConfig;


class PayementRequest
{
    private $receiverWalletId;
    private $amount;

    public function __construct(string $receiverWalletId, float $amount)
    {
        $this->receiverWalletId = $receiverWalletId;
        $this->amount = $amount;
    }

    public function getReceiverWalletId(): string
    {
        return $this->receiverWalletId;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }
}
