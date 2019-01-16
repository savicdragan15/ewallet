<?php

namespace App\Models;

/**
 * App\Models\Location
 *
 * @property int $id
 * @property string $name
 * @property string|null $image
 * @property string $latitude
 * @property string $longitude
 * @property int|null $user_id
 * @property int $active 1 - active, 0 - inactive
 * @property string|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Location whereUserId($value)
 * @mixin \Eloquent
 */
class Location extends BaseModel
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'image',
        'latitude',
        'longitude',
        'user_id',
        'active'
    ];
}
