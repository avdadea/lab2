<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planet extends Model
{
    // Disable automatic timestamps
    public $timestamps = false;

    protected $fillable = ['name', 'type', 'isDeleted'];


    /**
     * Get the satellites for the planet.
     */
    public function satellites()
    {
        return $this->hasMany(Satellite::class, 'planet_id', 'id');
    }
}
