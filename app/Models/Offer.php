<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Offer extends Model
{
    use HasFactory;
    protected $fillable = [
        'en_description',
        'ar_description',
        'image',
        // spatie translation 
    ];
    protected $appends = ['description'];

    public function getDescriptionAttribute()
    {
        $locale = App::getLocale(); 
        $localizedField = $locale . '_description'; 
        
        return $this->attributes[$localizedField];
    }
}
