<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    protected $fillable = ['name','is_active'];

    public function assets()
    {
        return $this->hasMany(Asset::class);
    }
    use HasFactory;
}
