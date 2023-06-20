<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function author() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function blog() {
        return $this->belongsTo(Blog::class);
    }

    public function reply() {
        return $this->hasMany(Comment::class, 'reply_id');
    }

    public function comment() {
        return $this->belongsTo(Comment::class, 'reply_id', 'id');
    }

    public function scopeVisible($query)
    {
        return $query->where('visibility', '<=', now());
    }
}
