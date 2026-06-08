<?php

namespace App\Services;

use App\Models\Ad;
use App\Models\AppNotification;
use App\Models\Conversation;
use App\Models\User;

class NotificationService
{
    public function notifyNewMessage(Conversation $conversation, User $sender): void
    {
        $conversation->loadMissing(['ad', 'owner', 'sender']);

        $recipientId = $conversation->owner_id;

        if ($recipientId === $sender->id) {
            $recipientId = $conversation->sender_id;
        }

        if ($recipientId === null || $recipientId === $sender->id) {
            return;
        }

        AppNotification::query()->create([
            'user_id' => $recipientId,
            'type' => AppNotification::TYPE_MESSAGE,
            'data' => [
                'actor_name' => $sender->name,
                'ad_id' => $conversation->ad_id,
                'ad_title' => $conversation->ad->title,
                'conversation_id' => $conversation->id,
                'url' => route('messages', $conversation),
            ],
        ]);
    }

    public function notifyMessageFromGuest(Conversation $conversation, string $guestName): void
    {
        $conversation->loadMissing(['ad']);

        AppNotification::query()->create([
            'user_id' => $conversation->owner_id,
            'type' => AppNotification::TYPE_MESSAGE,
            'data' => [
                'actor_name' => $guestName,
                'ad_id' => $conversation->ad_id,
                'ad_title' => $conversation->ad->title,
                'conversation_id' => $conversation->id,
                'url' => route('messages', $conversation),
            ],
        ]);
    }

    public function notifyFavorite(Ad $ad, User $favoriter): void
    {
        if ($ad->user_id === $favoriter->id) {
            return;
        }

        AppNotification::query()->create([
            'user_id' => $ad->user_id,
            'type' => AppNotification::TYPE_FAVORITE,
            'data' => [
                'actor_name' => $favoriter->name,
                'ad_id' => $ad->id,
                'ad_title' => $ad->title,
                'url' => route('my-ads'),
            ],
        ]);
    }
}
