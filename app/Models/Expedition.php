<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expedition extends Model
{
    protected $fillable = ['destination', 'crew_size', 'explorer_id'];
   
    public function explorer()
    {
        return $this->belongsTo(Explorer::class);
    }
    use HasFactory;
}
