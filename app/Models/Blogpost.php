<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blogpost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'body',
        'user_id',
        'category_id',
    ];

    protected $table = 'blogposts';

    public function scopeSearch($query_builder, array $scope_params) {
        return Blogpost::where('user_id', $scope_params['user_id'])
            ->where('title', 'like', '%' . $scope_params['search_term'] . '%')
            ->orWhere('body', 'like', '%' . $scope_params['search_term'] . '%');
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function tags() {
        return $this->belongsToMany(Tag::class);
    }

    public function author() {
        return $this->belongsTo(User::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function likes() {
        return $this->morphMany(Like::class, 'likeable');
    }
}

