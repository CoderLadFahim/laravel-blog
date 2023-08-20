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

    public function scopeSearch($query_builder, string $search_term) {
        return Blogpost::where('title', 'like', '%' . $search_term . '%')
            ->orWhere('body', 'like', '%' . $search_term . '%');
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
}
