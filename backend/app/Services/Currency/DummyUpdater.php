<?php

namespace App\Services\Currency;

use App\Contracts\CurrencyUpdater;
use App\Models\Currency;
use GuzzleHttp\Client;

class DummyUpdater implements CurrencyUpdater
{
    public function __construct(private Client $httpClient)
    {
    }

    public function update(Currency $currency): void
    {
        // send request to external api
        // $responce = $this->httpClient->get('/someBankApi/currencyRate');

        // process result
        // $newCost = $responce->getBody()->getContents();

        // store result to db
        $currency->cost = rand(60000, 85000);
        $currency->save();
    }
}
