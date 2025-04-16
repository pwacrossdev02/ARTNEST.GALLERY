<div class="chat-container" data-product-id="{{ $conversation->product_id }}" data-receiver-id="{{ $conversation->receiver_id }}">
    <div class="chat-messages p-3 border rounded" style="max-height: 400px; overflow-y: auto;">
        @foreach ($messages as $message)
            <div class="chat-message mb-3 p-2 rounded 
                        {{ $message->user_id == Auth::id() ? 'bg-primary text-white text-right ml-auto' : 'bg-light' }}"
                 style="max-width: 75%; {{ $message->user_id == Auth::id() ? 'align-self-end' : '' }}">
                
                <!-- Display name and timestamp -->
                <div class="mb-1 d-flex align-items-center ">
                   
                    <strong class="text-lg">{{ $message->user->name }}</strong>
                    <p class="mb-0 text-sm ml-2 capitalize">{{ $message->message }}</p>
                </div>
                
                <small class="text-sm">{{ date('d M Y, h:i A', strtotime($message->created_at)) }}</small>
                <!-- Display message content -->
            </div>
        @endforeach
    </div>

    <!-- Message input form -->
    <form id="send-message-form" class="mt-3" action="{{ route('messages.store') }}" method="POST">
        @csrf
        <input type="hidden" name="conversation_id" value="{{ $conversation->id }}">
        <input type="hidden" name="product_id" value="{{ $conversation->product_id }}">
        <input type="hidden" name="receiver_id" value="{{ $conversation->receiver_id }}">
        
        <div class="input-group">
            <input type="text" name="message" class="form-control" placeholder="Type your message..." required>
            <div class="input-group-append">
                <button class="btn btn-primary" type="submit">Send</button>
            </div>
        </div>
    </form>
</div>

<!-- Styles for chat messages (optional) -->
<style>
    .chat-container {
        background-color: #f8f9fa;
    }
    .chat-messages {
        display: flex;
        flex-direction: column;
    }
    .chat-message {
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 5px;
    }
    .bg-primary {
        background-color: #007bff !important;
        color: white !important;
    }
    .text-right {
        text-align: right;
    }
</style>
