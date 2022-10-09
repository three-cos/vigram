<?php

namespace App\Services\Currency;

use App\Dtos\Money;
use App\Models\Currency;

class Converter
{
    public function convert(Money $money, Currency $currency): Money
    {
        if ($money->getCurrency()->id === $currency->id) {
            return $money;
        }

        $convertedAmount = $money->getAmount() * $this->getCurrencyRatio($money->getCurrency(), $currency);

        return new Money($convertedAmount, $currency);
    }

    private function getCurrencyRatio(Currency $from, Currency $to): float
    {
        return $from->cost / $to->cost;
    }
}