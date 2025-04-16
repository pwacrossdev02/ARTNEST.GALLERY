<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conversation;
use App\Models\BusinessSetting;
use App\Models\Message;
use App\Models\Product;
use Auth;
use Mail;
use App\Mail\ConversationMailManager;

class ConversationMessagesController extends Controller
{
    public function __construct()
    {
        // Staff Permission Check
        $this->middleware(['permission:view_all_product_conversations'])->only('admin_index');
        $this->middleware(['permission:delete_product_conversations'])->only('destroy');
    }

    public function fetchMessages(Request $request)
    {
        \Log::info('Product ID: ' . $request->product_id);
        \Log::info('Receiver ID: ' . $request->receiver_id);
    
        try {
            $conversation = Conversation::where('product_id', $request->product_id)
                        ->where(function($query) use ($request) {
                            $query->where('sender_id', Auth::id())
                                  ->orWhere('receiver_id', Auth::id());
                        })->first();
    
            if (!$conversation) {
                $conversation = new Conversation();
                $conversation->sender_id = Auth::id();
                $conversation->receiver_id = $request->receiver_id;
                $conversation->product_id = $request->product_id;
                $conversation->title = 'Product Conversation';
                $conversation->save();
            }
    
            $messages = Message::where('conversation_id', $conversation->id)->get();
            return view('partials.messages', compact('messages', 'conversation'));
        } catch (DecryptException $e) {
            \Log::error("Decryption failed. Error: " . $e->getMessage());
            return response()->json(['error' => 'Invalid encrypted data'], 500);
        }
    }
    
    
 public function sendMessage(Request $request)
{
    // Check if a conversation already exists for this product and users
    $conversation = Conversation::where('product_id', $request->product_id)
                    ->where(function($query) {
                        $query->where('sender_id', Auth::id())
                              ->orWhere('receiver_id', Auth::id());
                    })
                    ->first();

    // If no conversation exists, create a new one
    if (!$conversation) {
        $conversation = new Conversation();
        $conversation->sender_id = Auth::id();
        $conversation->receiver_id = $request->receiver_id;
        $conversation->product_id = $request->product_id;
        $conversation->title = 'Product Conversation';
        $conversation->save();
    }

    // Create a new message in this conversation
    $message = new Message();
    $message->conversation_id = $conversation->id;
    $message->user_id = Auth::id();
    $message->message = $request->message;
    $message->save();

    // Fetch all messages in this conversation
    $messages = Message::where('conversation_id', $conversation->id)->with('user')->get();

    // Return a partial view with messages to update the chat UI
    return view('partials.messages', compact('messages', 'conversation'));
}
    
}
