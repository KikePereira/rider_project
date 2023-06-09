<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class MessageController extends Controller
{
    /**
     * Enviar un mensaje a un amigo.
     */
    public function send(User $friend, Request $request)
    {
        $user = auth()->user();
        $message = new Message();
        $message->sender_id = $user->id;
        $message->receiver_id = $friend->id;
        $message->message = $request->message;
        $message->save();

        return redirect()->back()->with('success', 'Mensaje enviado correctamente');
    }

    public function viewConversation(User $friend)
    {
        $user = auth()->user();

        $messages = Message::where(function ($query) use ($user, $friend) {
                $query->where('sender_id', $user->id)
                    ->where('receiver_id', $friend->id);
            })
            ->orWhere(function ($query) use ($user, $friend) {
                $query->where('sender_id', $friend->id)
                    ->where('receiver_id', $user->id);
            })
            ->orderBy('created_at')
            ->get();

        return view('messages.conversation', compact('friend', 'messages'));
    }

public function index()
{
    $user = Auth::user();
    $conversations = User::whereHas('sentMessages', function ($query) use ($user) {
        $query->where('receiver_id', $user->id);
    })->orWhereHas('receivedMessages', function ($query) use ($user) {
        $query->where('sender_id', $user->id);
    })->get();

    return view('messages/open_conver', compact('conversations'));
}

}
