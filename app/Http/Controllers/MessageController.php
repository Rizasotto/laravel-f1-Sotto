<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $conversations = auth()->user()->conversations()
            ->with('messages')
            ->latest('updated_at')
            ->paginate(20);

        return view('messages.index', compact('conversations'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'recipient_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        // Create or get conversation
        $conversation = auth()->user()->conversations()
            ->firstOrCreate(
                ['recipient_id' => $validated['recipient_id']],
                ['recipient_id' => $validated['recipient_id']]
            );

        // Create message
        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'message' => $validated['message'],
        ]);

        return response()->json([
            'success' => true,
            'message' => $message,
        ]);
    }

    public function getConversations()
    {
        $conversations = auth()->user()->conversations()
            ->with('messages')
            ->latest('updated_at')
            ->get();

        return response()->json($conversations);
    }
}
