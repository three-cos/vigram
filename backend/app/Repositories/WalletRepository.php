<?php

namespace App\Repositories;

use App\Enums\TransactionReason;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;

class WalletRepository
{
    public function getRefundsRawSql(int $wallet_id, int $days = 7)
    {
        if ($days < 1) {
            throw new InvalidArgumentException('getRefunds() minimum days = 1');
        }

        return DB::select('
            SELECT
                SUM(t.amount) as sum
            FROM
                `wallets` w
            LEFT JOIN wallet_transactions t
                ON t.wallet_id = w.id
            WHERE
                w.id = :wallet_id
                AND t.reason = :reason
                AND t.created_at > :since
        ', [
            'wallet_id' => $wallet_id,
            'reason' => TransactionReason::REFUND->value,
            'since' => now()->subDays($days),
        ])[0]->sum;
    }

    public function getRefundsLaravelWay(int $wallet_id, int $days = 7)
    {
        if ($days < 1) {
            throw new InvalidArgumentException('getRefunds() minimum days = 1');
        }

        $wallet = Wallet::query()->findOrFail($wallet_id);

        return $wallet->transactions()
            ->getBaseQuery()
            ->where('reason', TransactionReason::REFUND)
            ->where('created_at', '>', now()->subDays($days))
            ->sum('amount');
    }
}