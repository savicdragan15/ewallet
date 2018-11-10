<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\WalletType
 *
 * @property int $id
 * @property string $name
 * @property string|null $icon
 * @property int $active 1 - active, 0 - inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Wallet $wallet_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletType newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletType newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletType query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletType whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletType whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletType whereIcon($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletType whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletType whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\WalletType whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class WalletType extends Model
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wallet_type()
    {
        return $this->hasOne('App\Models\Wallet');
    }
}
