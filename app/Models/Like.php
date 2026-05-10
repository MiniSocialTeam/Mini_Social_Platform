<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $primaryKey = 'id_like';
    public $timestamps = false; // On gère uniquement created_at manuellement ou via DB
    protected $fillable = ['post_id', 'user_id'];

    public function post() {
        return $this->belongsTo(Post::class, 'post_id', 'post_id');
    }
}
