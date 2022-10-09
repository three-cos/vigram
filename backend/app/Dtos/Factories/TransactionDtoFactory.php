<?php

namespace App\Dtos\Factories;

use App\Dtos\Money;
use App\Dtos\TransactionDto;
use App\Enums\TransactionReason;
use App\Enums\TransactionType;
use App\Exceptions\TransactionException;
use App\Models\Currency;
use App\Models\Wallet;
use Illuminate\Http\Request;

class TransactionDtoFactory
{
    public static function fromRequest(Request $request): TransactionDto
    {
        return self::create([
            'wallet_id' => $request->input('wallet_id'),
            'type' => $request->input('type'),
            'amount' => $request->input('amount'),
            'currency' => $request->input('currency'),
            'reason' => $request->input('reason'),
        ]);
    }

    public function fromArray(array $data): TransactionDto
    {
        return self::create([
            'wallet_id' => $data['wallet_id'],
            'type' => $data['type'],
            'amount' => $data['amount'],
            'currency' => $data['currency'],
            'reason' => $data['reason'],
        ]);
    }
    
    private static function create(array $data): TransactionDto
    {
        if (! $wallet = Wallet::query()->find($data['wallet_id'])) {
            throw new TransactionException('Wallet is not found');
        }

        if (! $currency = Currency::query()->where('code', $data['currency'])->first()) {
            throw new TransactionException('Currency is not found');
        }

        if (! $type = TransactionType::tryFrom($data['type'])) {
            throw new TransactionException('Type is not allowed');
        }

        if (! $reason = TransactionReason::tryFrom($data['reason'])) {
            throw new TransactionException('Reason is not allowed');
        }

        if ($data['amount'] < 0.01) {
            throw new TransactionException('Transaction amount cannot be less than 0.01');
        }
        
        $amount = new Money($data['amount'], $currency);

        return new TransactionDto(
            wallet: $wallet,
            type: $type,
            reason: $reason,
            amount: $amount,
        );
    }
}