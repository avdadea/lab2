<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    protected $fillable = ['name', 'location'];

    public function renovations()
    {
        return $this->hasMany(Renovation::class);
    }
    use HasFactory;
}
