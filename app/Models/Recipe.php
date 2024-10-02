<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recipe extends Model
{
    protected $fillable = ['title', 'difficulty', 'chef_id'];
   
    public function chef()
    {
        return $this->belongsTo(Chef::class);
    }
    use HasFactory;
}
