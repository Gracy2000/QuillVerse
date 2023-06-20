<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'about',
        'image_path'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function blogs() {
        return $this->hasMany(Blog::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function isAdmin(): bool {
        return $this->role === 'admin';
    }

    public function isOwner(Blog $blog): bool {
        return $this->id === $blog->user_id;
    }


    public function getImagePathAttribute() {
        return '/storage/' . $this->attributes['image_path'];
    }

    public function deleteImage() {
        if(isset($this->attributes['image_path']) && $this->attributes['image_path'] != 'users/default.jpg') {
            Storage::delete($this->attributes['image_path']);
        }
    }

    public function scopeVerified($query)
    {
        return $query->whereNotNull('email_verified_at');
    }

    public function scopeUnverified($query)
    {
        return $query->whereNull('email_verified_at');
    }
}
