<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PasswordResetCode extends Model
{
    use HasFactory;
    protected $fillable = [
        'email',
        'code',
        'expired_at',
    ];
    protected $casts = [
        'created_at' => 'date:Y-m-d h:i a',
        'updated_at' => 'date:Y-m-d h:i a',
    ];
}
