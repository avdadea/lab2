<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Satellite
 *
 * @property $id
 * @property $name
 * @property $isDeleted
 * @property $planet_id
 * @property $created_at
 * @property $updated_at
 *
 * @property Planet $planet
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Satellite extends Model
{
    
    protected $perPage = 20;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['name', 'isDeleted', 'planet_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function planet()
    {
        return $this->belongsTo(\App\Models\Planet::class, 'planet_id', 'id');
    }
    
}
