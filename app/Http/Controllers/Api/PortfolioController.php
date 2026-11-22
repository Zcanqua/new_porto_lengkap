<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use Illuminate\Http\JsonResponse;

class PortfolioController extends Controller
{
    /**
     * POST /api/portfolio/messages
     */
    public function storeMessage(StoreMessageRequest $request): JsonResponse
    {
        $validatedData = $request->validated();

        $cleanData = [
            'sender_name' => strip_tags($validatedData['sender_name']),
            'sender_email' => filter_var($validatedData['sender_email'], FILTER_SANITIZE_EMAIL),
            'subject' => strip_tags($validatedData['subject']),
            'body' => strip_tags($validatedData['body']),
        ];

        $message = Message::create($cleanData);

        return response()->json([
            'status' => 'success',
            'message' => 'Pesan Anda berhasil dikirim! Terima kasih telah menghubungi saya.',
            'data' => [
                'id' => $message->id,
                'sender_name' => $message->sender_name,
                'sender_email' => $message->sender_email,
                'subject' => $message->subject,
                'body' => $message->body,
                'created_at' => $message->created_at->isoFormat('D MMMM Y, HH:mm'),
            ],
        ], 201);
    }
}
