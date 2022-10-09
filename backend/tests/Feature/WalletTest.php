<?php

namespace Tests\Feature;

use App\Enums\TransactionReason;
use App\Enums\TransactionType;
use App\Exceptions\TransactionException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    use RefreshDatabase;

    public function test_wallet_can_process_debit_transaction()
    {
        $usd = self::createUsd();
        $user = self::createUser();

        $response = $this->post(route('wallet.transaction'), [
            'wallet_id' => $user->wallet->id,
            'type' => TransactionType::DEBIT->value,
            'amount' => 2,
            'currency' => $usd->code,
            'reason' => TransactionReason::STOCK->value,
        ]);

        $response->assertStatus(200);

        $this->assertEquals(200, $response->json('balance'));
    }

    public function test_wallet_can_process_credit_transaction()
    {
        $usd = self::createUsd();
        $user = self::createUser();

        $user->wallet->balance = 20000;
        $user->wallet->save();

        $response = $this->post(route('wallet.transaction'), [
            'wallet_id' => $user->wallet->id,
            'type' => TransactionType::CREDIT->value,
            'amount' => 1,
            'currency' => $usd->code,
            'reason' => TransactionReason::REFUND->value,
        ]);

        $response->assertStatus(200);

        $this->assertEquals(100, $response->json('balance'));
    }

    public function test_wallet_cannot_process_credit_less_than_balance()
    {
        $usd = self::createUsd();
        $user = self::createUser();
        
        $user->wallet->balance = 10000;
        $user->wallet->save();
        
        $this->withoutExceptionHandling();
        $this->expectException(TransactionException::class);
        
        $response = $this->post(route('wallet.transaction'), [
            'wallet_id' => $user->wallet->id,
            'type' => TransactionType::CREDIT->value,
            'amount' => 2,
            'currency' => $usd->code,
            'reason' => TransactionReason::REFUND->value,
        ]);
    }
}
