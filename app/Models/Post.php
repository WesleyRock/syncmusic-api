<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['content', 'music', 'user_id'];

     protected $casts = [
        'music' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function likes()
{
    return $this->hasMany(\App\Models\Like::class);
}
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
