<?php
namespace App\Http\Controllers;

use App\Models\FriendRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FriendRequestController extends Controller
{
    // Envoyer une demande
    public function send(User $user)
    {
        $me = Auth::user();

        if ($me->user_id === $user->user_id) {
            return back()->with('error', 'Action invalide.');
        }

        if ($me->isFriendWith($user->user_id) || $me->hasPendingRequestWith($user->user_id)) {
            return back()->with('error', 'Demande déjà existante.');
        }

        FriendRequest::create([
            'sender_id'   => $me->user_id,
            'receiver_id' => $user->user_id,
        ]);

        return back()->with('success', 'Demande de connexion envoyée.');
    }

    // Accepter
    public function accept(FriendRequest $friendRequest)
    {
        $this->authorizeReceiver($friendRequest);

        $friendRequest->update(['status' => 'accepted']);

        return back()->with('success', 'Connexion acceptée.');
    }

    // Refuser
    public function decline(FriendRequest $friendRequest)
    {
        $this->authorizeReceiver($friendRequest);

        $friendRequest->update(['status' => 'declined']);

        return back()->with('success', 'Demande refusée.');
    }

    // Annuler (par l'expéditeur)
    public function cancel(FriendRequest $friendRequest)
{
    if ($friendRequest->sender_id !== Auth::id()) {
        abort(403);
    }

    // On ne peut annuler qu'une demande encore en attente
    if ($friendRequest->status !== 'pending') {
        return back()->with('error', 'Cette demande ne peut plus être annulée.');
    }

    $friendRequest->delete();

    return back()->with('success', 'Demande annulée.');
}
    // Liste des demandes reçues en attente
    public function index(Request $request)
{
    $requests = FriendRequest::where('receiver_id', Auth::id())
        ->where('status', 'pending')
        ->with('sender')
        ->latest()
        ->get();

    $searchResults = collect();

    if ($request->filled('q')) {
        $searchResults = User::where('user_id', '!=', Auth::id())
            ->where(function ($query) use ($request) {
                $query->where('first_name', 'like', '%'.$request->q.'%')
                      ->orWhere('last_name',  'like', '%'.$request->q.'%')
                      ->orWhere('email',       'like', '%'.$request->q.'%');
            })
            ->with(['sentRequests', 'receivedRequests'])
            ->limit(20)
            ->get();
    }

    return view('friends.requests', compact('requests', 'searchResults'));
}

    private function authorizeReceiver(FriendRequest $friendRequest): void
    {
        if ($friendRequest->receiver_id !== Auth::id()) {
            abort(403);
        }
    }
    
}