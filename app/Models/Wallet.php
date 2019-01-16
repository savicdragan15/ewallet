<?php

namespace App\Models;

/**
 * App\Models\Wallet
 *
 * @property int $id
 * @property string $name
 * @property int|null $user_id
 * @property int|null $wallet_type_id
 * @property float $amount
 * @property int $active 1 - active, 0 - inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\WalletType $wallet_type
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Wallet whereWalletTypeId($value)
 * @mixin \Eloquent
 * @property-read \App\Models\WalletType $walletType
 */
class Wallet extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'user_id',
        'wallet_type_id',
        'amount',
        'active',
    ];

    /**
     * Relationship always get
     *
     * @var array
     */
    protected $with = ['walletType'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function walletType()
    {
        return $this->hasOne('App\Models\WalletType', 'id', 'wallet_type_id');
    }
}
