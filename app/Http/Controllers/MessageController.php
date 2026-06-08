<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Ad;
use App\Models\Conversation;
use App\Models\User;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function __construct(private NotificationService $notifications) {}
    public function index(?Conversation $conversation = null): View
    {
        $user = auth()->user();

        $conversations = $this->conversationsFor($user);

        if ($conversation !== null) {
            abort_unless($conversation->isParticipant($user), 403);
        } else {
            $conversation = $conversations->first();
        }

        $messages = collect();
        $isViewerOwner = false;

        if ($conversation !== null) {
            $conversation->load(['ad', 'owner', 'sender', 'messages']);
            $isViewerOwner = $conversation->isOwner($user);

            $conversation->messages()
                ->where('direction', $conversation->incomingDirectionFor($user))
                ->whereNull('read_at')
                ->update(['read_at' => now()]);

            $messages = $conversation->messages;
        }

        return view('messages', compact('conversations', 'conversation', 'messages', 'isViewerOwner'));
    }

    public function store(StoreMessageRequest $request, Ad $ad): RedirectResponse
    {
        abort_unless($ad->isPublished(), 404);
        abort_if(auth()->check() && auth()->id() === $ad->user_id, 403);

        $validated = $request->validated();

        $conversation = DB::transaction(function () use ($request, $ad, $validated): Conversation {
            $conversation = $this->findOrCreateConversation($request, $ad, $validated);

            $conversation->messages()->create([
                'direction' => Conversation::DIRECTION_CLIENT,
                'body' => $validated['body'],
            ]);

            $conversation->update(['last_message_at' => now()]);

            return $conversation;
        });

        if ($request->user()) {
            $this->notifications->notifyNewMessage($conversation, $request->user());
        } else {
            $this->notifications->notifyMessageFromGuest($conversation, $validated['guest_name']);
        }

        if ($request->user()) {
            return redirect()
                ->route('messages', $conversation)
                ->with('status', '¡Mensaje enviado! Puedes seguir la conversación aquí.');
        }

        return redirect()
            ->route('listing', $ad)
            ->with('status', '¡Mensaje enviado! El anunciante te responderá pronto.');
    }

    public function reply(Request $request, Conversation $conversation): RedirectResponse
    {
        $user = auth()->user();

        abort_unless($conversation->isParticipant($user), 403);

        if ($conversation->isGuestConversation() && $conversation->isOwner($user)) {
            return redirect()
                ->route('messages', $conversation)
                ->withErrors(['body' => 'Este cliente escribió sin cuenta. Responde por email.']);
        }

        $validated = $request->validate([
            'body' => ['required', 'string', 'max:5000'],
        ], [
            'body.required' => 'Escribe un mensaje antes de enviar.',
            'body.max' => 'El mensaje no puede superar los 5000 caracteres.',
        ]);

        DB::transaction(function () use ($conversation, $user, $validated): void {
            $conversation->messages()->create([
                'direction' => $conversation->outgoingDirectionFor($user),
                'body' => $validated['body'],
            ]);

            $conversation->update(['last_message_at' => now()]);
        });

        $this->notifications->notifyNewMessage($conversation, $user);

        return redirect()->route('messages', $conversation);
    }

    private function conversationsFor(User $user): Collection
    {
        $received = $user->receivedConversations()
            ->with(['ad', 'sender', 'owner', 'latestMessage'])
            ->get();

        $sent = $user->sentConversations()
            ->with(['ad', 'sender', 'owner', 'latestMessage'])
            ->get();

        return $received
            ->merge($sent)
            ->unique('id')
            ->sortByDesc('last_message_at')
            ->values();
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    private function findOrCreateConversation(StoreMessageRequest $request, Ad $ad, array $validated): Conversation
    {
        if ($request->user()) {
            return Conversation::query()->firstOrCreate(
                [
                    'ad_id' => $ad->id,
                    'sender_id' => $request->user()->id,
                ],
                [
                    'owner_id' => $ad->user_id,
                    'subject' => $validated['subject'] ?? "Me interesa: {$ad->title}",
                ]
            );
        }

        return Conversation::query()->firstOrCreate(
            [
                'ad_id' => $ad->id,
                'guest_email' => $validated['guest_email'],
            ],
            [
                'owner_id' => $ad->user_id,
                'guest_name' => $validated['guest_name'],
                'subject' => $validated['subject'] ?? "Me interesa: {$ad->title}",
            ]
        );
    }
}
