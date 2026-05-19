<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    // ✅ Allow mass assignment for these fields
    protected $fillable = [
        'sender_id',
        'receiver_id', 
        'message'
    ];

    // ✅ If your primary key is 'id' (default), you can remove this.
    // If you use 'user_id' as PK, uncomment:
    // protected $primaryKey = 'user_id';
    // public $incrementing = false;
    // protected $keyType = 'string';
}