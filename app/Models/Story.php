<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{   
    protected $primaryKey = 'id_story';
    protected $fillable = ['image', 'user_id', 'expires_at'];
    
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function views() {
        return $this->hasMany(StoryView::class, 'story_id');
    }
}
