<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
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
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wallet_type()
    {
        return $this->hasOne('App\Models\WalletType', 'id', 'wallet_type_id');
    }
}
