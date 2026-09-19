<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $conversations = $user->conversations()
            ->with(['users'])
            ->orderByDesc('last_message_at')
            ->orderByDesc('id')
            ->get()
            ->map(function (Conversation $c) use ($user) {
                $other = $c->users->firstWhere('id', '!=', $user->id);
                $last = $c->messages()->latest('id')->first();
                $unread = $c->messages()
                    ->where('user_id', '!=', $user->id)
                    ->whereNull('read_at')
                    ->count();

                return [
                    'conversation' => $c,
                    'other' => $other,
                    'last' => $last,
                    'unread' => $unread,
                ];
            });

        return view('messages.index', compact('conversations'));
    }

    public function show(Request $request, Conversation $conversation): View
    {
        abort_unless($conversation->isParticipant($request->user()->id), 403);

        $messages = Message::with('sender')
            ->where('conversation_id', $conversation->id)
            ->orderBy('id')
            ->paginate(50);

        $conversation->messages()
            ->where('user_id', '!=', $request->user()->id)
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        $conversation->users()->updateExistingPivot($request->user()->id, [
            'last_read_at' => now(),
        ]);

        $other = $conversation->users->firstWhere('id', '!=', $request->user()->id);

        return view('messages.show', [
            'conversation' => $conversation,
            'messages' => $messages,
            'other' => $other,
        ]);
    }

    public function send(Request $request, Conversation $conversation): RedirectResponse
    {
        abort_unless($conversation->isParticipant($request->user()->id), 403);

        $data = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ]);

        Message::create([
            'conversation_id' => $conversation->id,
            'user_id' => $request->user()->id,
            'body' => $data['body'],
        ]);

        $conversation->forceFill(['last_message_at' => now()])->save();

        return redirect()->route('messages.show', $conversation);
    }

    public function start(Request $request, User $user): RedirectResponse
    {
        $me = $request->user();

        if ($me->id === $user->id) {
            return redirect()->route('messages.index');
        }

        $conversation = Conversation::findOrCreateBetween($me->id, $user->id);

        return redirect()->route('messages.show', $conversation);
    }
}
