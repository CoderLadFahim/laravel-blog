<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupJoinRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'requester_id',
        'group_id',
        'is_approved',
    ];

    public function group() {
        return $this->belongsTo(Group::class);
    }

    public function requester() {
        return $this->belongsTo(User::class);
    }
}
