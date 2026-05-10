<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $primaryKey = 'post_id';
    protected $fillable = ['content', 'user_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    // Pour plus tard : la relation avec les Likes du MLD
    public function likes()
    {
        return $this->hasMany(Like::class, 'post_id', 'post_id');
    }

    // Petite fonction pratique pour savoir si l'utilisateur a déjà liké
    public function isLikedBy($userId) {
        return $this->likes()->where('user_id', $userId)->exists();
    }
}
