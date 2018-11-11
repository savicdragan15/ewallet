<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $order_number
 * @property int|null $user_id
 * @property int|null $market_id
 * @property float $amount
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUserId($value)
 * @mixin \Eloquent
 * @property int|null $wallet_id
 * @property-read \App\Models\Wallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereWalletId($value)
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $flag
 * @property string|null $location
 * @property-read \App\Models\Market $market
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereLongitude($value)
 */
class Order extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_number',
        'wallet_id',
        'user_id',
        'market_id',
        'location_id',
        'amount',
        'latitude',
        'longitude',
        'flag',
        'location',
    ];

    /**
     * Get wallet for order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function wallet()
    {
        return $this->hasOne('App\Models\Wallet', 'id', 'wallet_id');
    }

    /**
     * Get market for order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function market()
    {
        return $this->hasOne('App\Models\Market', 'id', 'market_id');
    }

    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'location_id');
    }


}