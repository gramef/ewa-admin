<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\EProvider;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ChatAPIController extends Controller
{
    /**
     * GET /api/chat_rooms
     * List all chat rooms for the authenticated user.
     * Works for both clients (user_id) and providers (via e_provider ownership).
     */
    public function index(Request $request): JsonResponse
    {
        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        // Find provider IDs owned by this user (for vendor app)
        $providerIds = EProvider::whereHas('users', fn($q) => $q->where('users.id', $user->id))->pluck('id')->toArray();

        $rooms = ChatRoom::with(['eProvider', 'eProvider.media', 'user', 'lastMessage'])
            ->where(function ($q) use ($user, $providerIds) {
                $q->where('user_id', $user->id);
                if (!empty($providerIds)) {
                    $q->orWhereIn('e_provider_id', $providerIds);
                }
            })
            ->orderByDesc('last_message_at')
            ->orderByDesc('updated_at')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $rooms,
        ]);
    }

    /**
     * POST /api/chat_rooms
     * Create or find an existing chat room.
     * Body: { e_provider_id, booking_id? }
     */
    public function store(Request $request): JsonResponse
    {
        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $request->validate([
            'e_provider_id' => 'required|integer|exists:e_providers,id',
            'booking_id' => 'nullable|integer',
        ]);

        // Find or create the chat room
        $room = ChatRoom::firstOrCreate(
            [
                'user_id' => $user->id,
                'e_provider_id' => $request->input('e_provider_id'),
            ],
            [
                'booking_id' => $request->input('booking_id'),
            ]
        );

        $room->load(['eProvider', 'eProvider.media', 'user', 'lastMessage']);

        return response()->json([
            'success' => true,
            'data' => $room,
        ]);
    }

    /**
     * GET /api/chat_rooms/{roomId}/messages
     * List all messages in a chat room.
     */
    public function messages(Request $request, $roomId): JsonResponse
    {
        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $room = ChatRoom::find($roomId);
        if (!$room) {
            return response()->json(['success' => false, 'message' => 'Chat room not found'], 404);
        }

        // Ensure user has access to this room
        $providerIds = EProvider::whereHas('users', fn($q) => $q->where('users.id', $user->id))->pluck('id')->toArray();
        if ($room->user_id !== $user->id && !in_array($room->e_provider_id, $providerIds)) {
            return response()->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        $limit = $request->input('limit', 50);
        $orderBy = $request->input('orderBy', 'created_at');
        $sortedBy = $request->input('sortedBy', 'asc');

        $messages = $room->messages()
            ->with('fromUser')
            ->orderBy($orderBy, $sortedBy)
            ->limit($limit)
            ->get();

        // Mark messages from the other party as read
        $room->messages()
            ->where('from_user_id', '!=', $user->id)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        return response()->json([
            'success' => true,
            'data' => $messages,
        ]);
    }

    /**
     * POST /api/chat_rooms/{roomId}/messages
     * Send a message in a chat room.
     * Body: { message }
     */
    public function sendMessage(Request $request, $roomId): JsonResponse
    {
        $user = auth('api')->user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $room = ChatRoom::find($roomId);
        if (!$room) {
            return response()->json(['success' => false, 'message' => 'Chat room not found'], 404);
        }

        // Ensure user has access
        $providerIds = EProvider::whereHas('users', fn($q) => $q->where('users.id', $user->id))->pluck('id')->toArray();
        if ($room->user_id !== $user->id && !in_array($room->e_provider_id, $providerIds)) {
            return response()->json(['success' => false, 'message' => 'Access denied'], 403);
        }

        $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $msg = ChatMessage::create([
            'chat_room_id' => $room->id,
            'from_user_id' => $user->id,
            'message' => $request->input('message'),
        ]);

        // Update the room's last_message_at
        $room->update(['last_message_at' => now()]);

        $msg->load('fromUser');

        return response()->json([
            'success' => true,
            'data' => $msg,
        ]);
    }
}
