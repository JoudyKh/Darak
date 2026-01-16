<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class Ser_sections extends Model
{
    use HasFactory;
    protected $fillable = [
        'en_name',
        'ar_name',
        'image',
        'en_description',
        'ar_description',
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
    public function services(){
        return $this->hasMany(Service::class, 'section_id');
    }
}
