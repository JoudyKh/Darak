<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicesImage extends Model
{
    use HasFactory;
    protected $fillable = [
        'file',
        'type',
        'service_id',
    ];
    public function service()
    {
        return $this->belongsTo(Service::class);
    }
}
