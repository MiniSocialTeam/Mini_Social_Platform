<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StoryView extends Model
{
    protected $table = 'story_views';
    protected $primaryKey = 'id_view';
    public $timestamps = false;

    // LA CORRECTION : Autorise le remplissage de ces colonnes
    protected $fillable = [
        'story_id', 
        'user_id', 
        'viewed_at'
    ];
}
