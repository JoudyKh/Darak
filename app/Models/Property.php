<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'en_name',
        'ar_name',
        'en_description',
        'ar_description',
        'total_price',
        'number',
        'area',
        'address',
        'section_id',
        'is_best',
        'longitude',
        'latitude',
    ];
    static $searchable = [
       'en_name',
        'ar_name',
        'en_description',
        'ar_description',
    ];
    protected $appends = ['name', 'description'];

    public function getNameAttribute()
    {
        $locale = App::getLocale(); 
        $localizedField = $locale . '_name'; 
        
        return $this->attributes[$localizedField];
    }
    public function getDescriptionAttribute()
    {
        $locale = App::getLocale(); 
        $localizedField = $locale . '_description'; 
        
        return $this->attributes[$localizedField];
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function section()
    {
        return $this->belongsTo(P_sections::class);
    }
    public function images()
    {
        return $this->hasMany(PropertiesImage::class);
    }
}
