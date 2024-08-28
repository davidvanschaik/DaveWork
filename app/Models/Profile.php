<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Profile extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'user_id',
        'bio',
        'avatar',
        'location'
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }
}