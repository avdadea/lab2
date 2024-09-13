<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'number','birthYear', 'team_id'];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function teams()
    {
        return $this->belongsTo(\App\Models\Team::class, 'team_id', 'id');
    }
    
}
