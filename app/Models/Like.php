<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'likeable_id',
        'likeable_type',
        'is_liked',
        'user_id',
    ];

    public function likeable() {
        $this->morphTo();
    }
}
