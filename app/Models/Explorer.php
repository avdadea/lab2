<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Explorer extends Model
{
    protected $fillable = ['name', 'nationality'];

    public function expeditions()
    {
        return $this->hasMany(Expedition::class);
    }
    use HasFactory;
}
