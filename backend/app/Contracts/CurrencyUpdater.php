<?php

namespace App\Contracts;

use App\Models\Currency;

interface CurrencyUpdater
{
    public function update(Currency $currency): void;
}
