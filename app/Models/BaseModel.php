<?phpnamespace App\Models;use GeneaLabs\LaravelModelCaching\Traits\Cachable;use Illuminate\Database\Eloquent\Model;/**
 * App\Models\BaseModel
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel disableCache()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel withCacheCooldownSeconds($seconds)
 * @mixin \Eloquent
 */
class BaseModel extends Model{    use Cachable;}