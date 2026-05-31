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
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Auth;

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

    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'user_id');
    }

    // Demandes envoyées
    public function sentRequests()
    {
        return $this->hasMany(FriendRequest::class, 'sender_id', 'user_id');
    }

    // Demandes reçues
    public function receivedRequests()
    {
        return $this->hasMany(FriendRequest::class, 'receiver_id', 'user_id');
    }

    // Amis acceptés (dans les deux sens)
    public function friends()
    {
        $sentIds = FriendRequest::where('sender_id', $this->user_id)
            ->where('status', 'accepted')
            ->pluck('receiver_id');

        $receivedIds = FriendRequest::where('receiver_id', $this->user_id)
            ->where('status', 'accepted')
            ->pluck('sender_id');

        return User::whereIn('user_id', $sentIds->merge($receivedIds));
    }

    // Helpers pratiques
    public function isFriendWith(int $userId): bool
{
    if ($this->relationLoaded('sentRequests') && $this->relationLoaded('receivedRequests')) {
        $sent     = $this->sentRequests->where('receiver_id', $userId)->where('status', 'accepted')->isNotEmpty();
        $received = $this->receivedRequests->where('sender_id', $userId)->where('status', 'accepted')->isNotEmpty();
        return $sent || $received;
    }

    return FriendRequest::where('status', 'accepted')
        ->where(function ($q) use ($userId) {
            $q->where(['sender_id' => $this->user_id, 'receiver_id' => $userId])
              ->orWhere(['sender_id' => $userId, 'receiver_id' => $this->user_id]);
        })->exists();
}

    
public function hasPendingRequestWith(int $userId): bool
{
    if ($this->relationLoaded('sentRequests') && $this->relationLoaded('receivedRequests')) {
        $sent     = $this->sentRequests->where('receiver_id', $userId)->where('status', 'pending')->isNotEmpty();
        $received = $this->receivedRequests->where('sender_id', $userId)->where('status', 'pending')->isNotEmpty();
        return $sent || $received;
    }

    return FriendRequest::where('status', 'pending')
        ->where(function ($q) use ($userId) {
            $q->where(['sender_id' => $this->user_id, 'receiver_id' => $userId])
              ->orWhere(['sender_id' => $userId, 'receiver_id' => $this->user_id]);
        })->exists();
}


public function index(Request $request)
{
    $me = Auth::user()->load(['sentRequests', 'receivedRequests']);

    $requests = FriendRequest::where('receiver_id', $me->user_id)
        ->where('status', 'pending')
        ->with('sender')
        ->latest()
        ->get();

    $searchResults = collect();

    if ($request->filled('q')) {
        $searchResults = User::where('user_id', '!=', $me->user_id)
            ->where(function ($q) use ($request) {
                $q->where('first_name', 'like', '%'.$request->q.'%')
                  ->orWhere('last_name',  'like', '%'.$request->q.'%')
                  ->orWhere('email',       'like', '%'.$request->q.'%');
            })
            ->limit(20)
            ->get();
    }

    return view('friends.requests', compact('requests', 'searchResults', 'me'));
}
}