<?php
namespace App\Models;

use App\Models\Story;
use App\Models\Post;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['first_name', 'last_name', 'email', 'password', 'bio', 'avatar'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $primaryKey = 'user_id';
    protected $appends = ['avatar_url'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ── ACCESSOR ──────────────────────────────────────────
    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }

        return 'https://ui-avatars.com/api/?name='
            . urlencode($this->first_name . ' ' . $this->last_name)
            . '&background=6c63ff&color=fff&size=120&rounded=true';
    }

    // ── RELATIONS ─────────────────────────────────────────
    public function posts()
    {
        return $this->hasMany(Post::class, 'user_id');
    }

    public function stories()
    {
        return $this->hasMany(Story::class, 'user_id');
    }
}