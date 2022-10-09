<?php

namespace App\Dtos;

use App\Models\Currency;

class Money
{
    public function __construct(
        private float $amount,
        private Currency $currency
    )
    {
    }

    public static function fromDb(
        int $amount,
        Currency $currency
    ): self
    {
        return new self($amount / 100, $currency);
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function toDb(): int
    {
        return $this->amount * 100;
    }
}