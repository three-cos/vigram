<?php

namespace App\Models;

use App\Dtos\Money;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * App\Models\Wallet
 *
 * @property int $id
 * @property int $user_id
 * @property int $currency_id
 * @property int $balance
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $owner
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\WalletTransaction[] $transactions
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wallet query()
 * @mixin \Eloquent
 * @property-read \App\Models\Currency|null $currency
 */
class Wallet extends Model
{
    protected $table = 'wallets';

    protected $guarded = [
        'id',
        'user_id',
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'currency_id', 'id');
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class, 'wallet_id', 'id')
            ->latest();
    }

    public function getBalanceAmount(): Money
    {
        return Money::fromDb($this->balance, $this->currency);
    }
}
