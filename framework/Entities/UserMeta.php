<?php
namespace SleepingOwl\Framework\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserMeta
 *
 * @property string $key
 * @property int $user_id
 * @property array $data
 * @property User $user
 */
class UserMeta extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'backend_users_meta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'data', 'user_id'
    ];


    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'data' => 'json'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}