<?php

namespace App\Dtos;

use App\Enums\TransactionReason;
use App\Enums\TransactionType;
use App\Models\Wallet;

class TransactionDto
{
    public function __construct(
        private Wallet $wallet,
        private TransactionType $type,
        private TransactionReason $reason,
        private Money $amount,
    )
    {
    }

    public function getWallet(): Wallet
    {
        return $this->wallet;
    }

    public function getType(): TransactionType
    {
        return $this->type;
    }

    public function getReason(): TransactionReason
    {
        return $this->reason;
    }

    public function getAmount(): Money
    {
        return $this->amount;
    }
}