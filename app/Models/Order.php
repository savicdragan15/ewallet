<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * App\Models\Order
 *
 * @property int $id
 * @property string $order_number
 * @property int|null $wallet_id
 * @property int|null $user_id
 * @property int|null $category_id
 * @property int|null $location_id
 * @property int|null $market_id
 * @property float $amount
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $flag
 * @property string|null $location_info
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category $category
 * @property-read \App\Models\Location $location
 * @property-read \App\Models\Market $market
 * @property-read \App\Models\Wallet $wallet
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order currentMonth($column)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order user($userId)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereFlag($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereLocationInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereMarketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereOrderNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereWalletId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 * @mixin \Eloquent
 * @property string|null $deleted_at
 * @method static bool|null forceDelete()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order onlyTrashed()
 * @method static bool|null restore()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereDeletedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withTrashed()
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Order withoutTrashed()
 * @property string|null $note
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Order whereNote($value)
 * @property-read \App\User $orderUser
 */
class Order extends BaseModel
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order_number',
        'wallet_id',
        'user_id',
        'category_id',
        'market_id',
        'location_id',
        'amount',
        'note',
        'latitude',
        'longitude',
        'flag',
        'location_info',
    ];

    /*
   |--------------------------------------------------------------------------
   | RELATIONS
   |--------------------------------------------------------------------------
   */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function orderUser()
    {
        return $this->hasOne('App\User', 'id', 'user_id');
    }

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

    /**
     * Get location for order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id', 'location_id');
    }

    /**
     * Get category for order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne('App\Models\Category', 'id', 'category_id');
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */
    /**
     * Scope by user_id
     *
     * @param $query
     * @param $userId
     * @return mixed
     */
    public function scopeUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope current month
     *
     * @param $query
     * @param $column
     * @return mixed
     */
    public function scopeCurrentMonth($query, $column)
    {
        return $query->whereRaw('MONTH('.$column.') = ?', [date('m')]);
    }

    /*
    |--------------------------------------------------------------------------
    | METHODS
    |--------------------------------------------------------------------------
    */

    /**
     * Get number of orders for current month
     *
     * @param User $user
     * @return mixed
     */
    public function getNumberOfOrdersCurrentMonth(User $user)
    {
        return $this->user($user->id)
            ->currentMonth('created_at')
            ->count();
    }

    /**
     * Get number order for user
     *
     * @param User $user
     * @return int
     */
    public function getNumberOfOrders(User $user)
    {
        return $this->user($user->id)->count();
    }

    /**
     * Get spent money for user in current month
     *
     * @param User $user
     * @return string
     */
    public function getSpentMoneyCurrentMonth(User $user)
    {
        return number_format($this->user($user->id)
            ->currentMonth('created_at')
            ->sum('amount'), 0, ',', '.');
    }

    /**
     * Get spent money for user
     *
     * @param User $user
     * @return string
     */
    public function getSpentMoney(User $user)
    {
        return number_format($this->user($user->id)->sum('amount'), 0, ',', '.');
    }

    /**
     * Get latest orders for user
     *
     * @param User $user
     * @param int $limit
     * @return Order[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getLatestOrders(User $user, $limit = 10)
    {
        return $this->user($user->id)->with(['category' => function ($q) {
            $q->select('id', 'name');
        }])
        ->orderByDesc('created_at')
        ->limit($limit)
        ->get(['amount', 'created_at', 'category_id']);
    }

    /**
     * @param User $user
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getSumOrdersByMonth(User $user, $limit = 12)
    {
        return \DB::table('orders')
            ->select(\DB::raw('SUM(amount) as sum, DATE_FORMAT(created_at, "%b %Y") as month'))
            ->where('user_id', $user->id)
            ->whereRaw('created_at >= LAST_DAY(NOW()) + INTERVAL 1 DAY - INTERVAL '.$limit.' MONTH')
            ->whereNull($this->getDeletedAtColumn())
            ->groupBy('month')
            ->get();
    }
}
