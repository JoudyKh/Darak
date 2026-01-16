<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class P_sections extends Model
{
    use HasFactory;
    protected $fillable = [
        'en_name',
        'ar_name',
        'image',
    ];
    static $searchable = [
        'en_name',
        'ar_name',
    ];
    protected $appends = ['name'];

    public function getNameAttribute()
    {
        $locale = App::getLocale(); 
        $localizedField = $locale . '_name'; 
        
        return $this->attributes[$localizedField];
    }
    public function properties(){
        return $this->hasMany(Property::class, 'section_id');
    }
}
