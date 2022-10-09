<?php

namespace Database\Seeders;

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencySeeder extends Seeder
{
    public const CURRENCIES = [
        'RUB' => [
            'name' => 'Российский рубль',
            'cost' => 100,
        ],
        'USD' => [
            'name' => 'Доллар США',
            'cost' => 6500,
        ],
        'EUR' => [
            'name' => 'Евро',
            'cost' => 6000,
        ],
    ];

    public function run()
    {
        foreach (self::CURRENCIES as $code => $data) {
            $currency = Currency::query()->firstOrCreate(
                [
                    'code' => $code,
                ],
                $data
            );

            $currency->forceFill($data);

            $currency->save();
        }
    }
}
