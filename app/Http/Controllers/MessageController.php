<?php

namespace App\Http\Controllers;

use App\Events\MessageBroadcast;
use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::orderBy('updated_at', 'DESC')->get();
        return view('chats.chat', ['messages' => $messages]);
    }

    public function store(Request $request, Message $message)
    {
        $validatedMessage = $request->validate([
            'message' => 'required',
        ]);

        $message->user_name = Auth::user()->name;
        $message->message = $validatedMessage['message'];
        $message->save();

        MessageBroadcast::dispatch($message);

        return redirect()->route('chat');
    }
}
