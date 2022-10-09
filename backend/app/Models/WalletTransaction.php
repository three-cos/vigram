<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * App\Models\WalletTransaction
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Wallet|null $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|WalletTransaction query()
 * @mixin \Eloquent
 * @property int $wallet_id
 * @property string $type
 * @property int $amount
 * @property-read \App\Models\Currency|null $currency
 */
class WalletTransaction extends Model
{
    protected $table = 'wallet_transactions';

    protected $guarded = [
        'id',
        'wallet_id',
    ];

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class, 'wallet_id', 'id');
    }

    public function currency(): HasOne
    {
        return $this->hasOne(Currency::class, 'currency_id', 'id');
    }
}
