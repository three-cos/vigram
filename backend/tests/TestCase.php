<?php

namespace Tests;

use App\Models\Currency;
use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public static function createUser()
    {
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $rub = self::createRub();

        $user->wallet()->create([
            'currency_id' => $rub->id,
        ]);
        
        return $user;
    }

    public static function createRub()
    {
        return Currency::create([
            'name' => 'ruble',
            'code' => 'RUB',
            'cost' => 1,
        ]);
    }

    public static function createUsd()
    {
        return Currency::create([
            'name' => 'dollars',
            'code' => 'USD',
            'cost' => 100,
        ]);
    }

    public static function createEuro()
    {
        return Currency::create([
            'name' => 'euro',
            'code' => 'EUR',
            'cost' => 50,
        ]);
    }
}
