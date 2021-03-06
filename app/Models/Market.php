<?php

namespace App\Models;

/**
 * App\Models\Market
 *
 * @property int $id
 * @property string $name
 * @property int|null $user_id
 * @property int $active 1 - active, 0 - inactive
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Market newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Market newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Market query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Market whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Market whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Market whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Market whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Market whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\Market whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 * @mixin \Eloquent
 */
class Market extends BaseModel
{
    //
}
