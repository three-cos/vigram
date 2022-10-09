<?php

namespace Tests\Unit;

use App\Dtos\Money;
use App\Services\Currency\Converter;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ConverterTest extends TestCase
{
    use RefreshDatabase;

    public function test_converter_converts_rub_to_usd()
    {
        $converter = new Converter();

        $money = new Money(100, self::createRub());

        $usd = self::createUsd();

        $convertedMoney = $converter->convert($money, $usd);

        $this->assertEquals(1, $convertedMoney->getAmount());
    }

    public function test_converter_converts_usd_to_rub()
    {
        $converter = new Converter();

        $money = new Money(1, self::createUsd());

        $rub = self::createRub();

        $convertedMoney = $converter->convert($money, $rub);

        $this->assertEquals(100, $convertedMoney->getAmount());
    }

    public function test_converter_converts_usd_to_eur()
    {
        $converter = new Converter();

        $money = new Money(1, self::createUsd());

        $eur = self::createEuro();
        
        $convertedMoney = $converter->convert($money, $eur);

        $this->assertEquals(2, $convertedMoney->getAmount());
    }

    public function test_converter_converts_eur_to_usd()
    {
        $converter = new Converter();

        $money = new Money(1, self::createEuro());

        $usd = self::createUsd();
        
        $convertedMoney = $converter->convert($money, $usd);

        $this->assertEquals(.5, $convertedMoney->getAmount());
    }
}
