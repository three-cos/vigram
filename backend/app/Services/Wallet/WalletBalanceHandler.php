<?php

namespace App\Services\Wallet;

use App\Dtos\TransactionDto;
use App\Enums\TransactionType;
use App\Exceptions\TransactionException;
use App\Services\Currency\Converter;
use Error;
use Illuminate\Support\Facades\DB;
use Throwable;

class WalletBalanceHandler
{
    public function __construct(private Converter $converter)
    {
    }

    public function handle(TransactionDto $dto): void {
        if ($dto->getType() === TransactionType::DEBIT) {
            $this->debit($dto);
        } 
        
        if ($dto->getType() === TransactionType::CREDIT) {
            $this->credit($dto);
        }
    }

    private function debit(TransactionDto $dto): void
    {
        $wallet = $dto->getWallet();
        $convertedAmount = $this->converter->convert($dto->getAmount(), $wallet->currency);
        $transactionAmount = $convertedAmount->toDb();

        DB::beginTransaction();

        try {
            $wallet->transactions()->create([
                'currency_id' => $dto->getAmount()->getCurrency()->id,
                'type' => $dto->getType()->value,
                'reason' => $dto->getReason()->value,
                'amount' => $transactionAmount,
            ]);
    
            $wallet->balance += $transactionAmount;
    
            $wallet->save();

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();

            throw new Error('Transaction cannot be stored, rollback', 0, $th);
        }
    }

    private function credit(TransactionDto $dto): void
    {
        $wallet = $dto->getWallet();
        $convertedAmount = $this->converter->convert($dto->getAmount(), $wallet->currency);
        $transactionAmount = $convertedAmount->toDb();

        if ($wallet->balance < $transactionAmount) {
            throw new TransactionException('Balance is less than credit amount');
        }

        DB::beginTransaction();

        try {
            $wallet->transactions()->create([
                'currency_id' => $dto->getAmount()->getCurrency()->id,
                'type' => $dto->getType()->value,
                'reason' => $dto->getReason()->value,
                'amount' => $transactionAmount,
            ]);
    
            $wallet->balance -= $transactionAmount;
    
            $wallet->save();

            DB::commit();
        } catch (Throwable $th) {
            DB::rollBack();

            throw new Error('Transaction cannot be stored, rollback', 0, $th);
        }
    }
}