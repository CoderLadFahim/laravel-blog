<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function members() {
        return $this->belongsToMany(User::class, 'group_members', 'group_id', 'user_id')->withPivot('is_admin');
    }
}