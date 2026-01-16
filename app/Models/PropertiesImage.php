<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertiesImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'file',
        'type',
        'property_id',
    ];
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
