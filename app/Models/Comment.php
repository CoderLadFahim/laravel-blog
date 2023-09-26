<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'user_id',
        'blogpost_id',
        'parent_id',
    ];

    public function parentComment() {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    public function replies() {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    public function blogpost() {
        return $this->belongsTo(Blogpost::class);
    }

    public function likes() {
        return $this->morphMany(Like::class, 'likeable');
    }
}
