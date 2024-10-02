<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chef extends Model
{
    protected $fillable = ['name', 'birth_year'];

    public function recipes()
    {
        return $this->hasMany(Recipe::class);
    }
    use HasFactory;
}
