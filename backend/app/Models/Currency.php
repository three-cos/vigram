<?php

namespace App\Models;

use App\Dtos\Money;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Currency
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property int $cost
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Currency query()
 * @mixin \Eloquent
 */
class Currency extends Model
{
    protected $table = 'currencies';

    protected $guarded = [
        'id',
    ];

    public function getCost(): Money
    {
        return Money::fromDb($this->cost, $this);
    }
}
