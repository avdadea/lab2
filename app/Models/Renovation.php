<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Renovation extends Model
{
    protected $fillable = ['description', 'cost', 'building_id'];
   
    public function building()
    {
        return $this->belongsTo(Building::class);
    }
    use HasFactory;
}
