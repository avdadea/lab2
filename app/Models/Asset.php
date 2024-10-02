<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = ['brand_name', 'production_date', 'asset_type_id'];

    protected $casts = [
        'production_date' => 'date',  // Automatically cast to a Carbon date object
    ];
    public function asset_type()
    {
        return $this->belongsTo(AssetType::class);
    }
    use HasFactory;
}
