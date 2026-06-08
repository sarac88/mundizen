<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\AppNotification;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_sending_message_creates_notification_for_ad_owner(): void
    {
        $owner = User::factory()->create();
        $sender = User::factory()->create();

        $ad = Ad::query()->create([
            'user_id' => $owner->id,
            'title' => 'Masaje relajante',
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $this->actingAs($sender)
            ->post(route('messages.store', $ad), [
                'body' => 'Hola, me interesa tu anuncio.',
            ])
            ->assertRedirect(route('messages', Conversation::query()->first()));

        $this->assertDatabaseHas('app_notifications', [
            'user_id' => $owner->id,
            'type' => AppNotification::TYPE_MESSAGE,
        ]);

        $notification = AppNotification::query()->first();
        $this->assertSame($sender->name, $notification->data['actor_name']);
        $this->assertSame('Masaje relajante', $notification->data['ad_title']);
    }

    public function test_guest_message_creates_notification_for_ad_owner(): void
    {
        $owner = User::factory()->create();

        $ad = Ad::query()->create([
            'user_id' => $owner->id,
            'title' => 'Masaje relajante',
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $this->post(route('messages.store', $ad), [
            'guest_name' => 'Ana García',
            'guest_email' => 'ana@example.com',
            'body' => 'Hola, me interesa tu anuncio.',
        ])->assertRedirect(route('listing', $ad));

        $this->assertDatabaseHas('app_notifications', [
            'user_id' => $owner->id,
            'type' => AppNotification::TYPE_MESSAGE,
        ]);

        $notification = AppNotification::query()->first();
        $this->assertSame('Ana García', $notification->data['actor_name']);
    }

    public function test_reply_creates_notification_for_other_participant(): void
    {
        $owner = User::factory()->create();
        $sender = User::factory()->create();

        $ad = Ad::query()->create([
            'user_id' => $owner->id,
            'title' => 'Masaje relajante',
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $conversation = Conversation::query()->create([
            'ad_id' => $ad->id,
            'owner_id' => $owner->id,
            'sender_id' => $sender->id,
            'subject' => 'Consulta',
            'last_message_at' => now(),
        ]);

        $this->actingAs($owner)
            ->post(route('messages.reply', $conversation), [
                'body' => 'Gracias por escribirme.',
            ])
            ->assertRedirect(route('messages', $conversation));

        $this->assertDatabaseHas('app_notifications', [
            'user_id' => $sender->id,
            'type' => AppNotification::TYPE_MESSAGE,
        ]);

        $notification = AppNotification::query()->first();
        $this->assertSame($owner->name, $notification->data['actor_name']);
    }

    public function test_favoriting_ad_creates_notification_for_owner(): void
    {
        $owner = User::factory()->create();
        $user = User::factory()->create();

        $ad = Ad::query()->create([
            'user_id' => $owner->id,
            'title' => 'Masaje relajante',
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $this->actingAs($user)
            ->postJson(route('favorites.toggle', $ad))
            ->assertOk()
            ->assertJson(['favorited' => true]);

        $this->assertDatabaseHas('app_notifications', [
            'user_id' => $owner->id,
            'type' => AppNotification::TYPE_FAVORITE,
        ]);

        $notification = AppNotification::query()->first();
        $this->assertSame($user->name, $notification->data['actor_name']);
        $this->assertSame('Masaje relajante', $notification->data['ad_title']);
    }

    public function test_unfavoriting_ad_does_not_create_notification(): void
    {
        $owner = User::factory()->create();
        $user = User::factory()->create();

        $ad = Ad::query()->create([
            'user_id' => $owner->id,
            'title' => 'Masaje relajante',
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $user->favorites()->attach($ad->id);

        $this->actingAs($user)
            ->postJson(route('favorites.toggle', $ad))
            ->assertOk()
            ->assertJson(['favorited' => false]);

        $this->assertDatabaseCount('app_notifications', 0);
    }

    public function test_owner_favoriting_own_ad_does_not_create_notification(): void
    {
        $owner = User::factory()->create();

        $ad = Ad::query()->create([
            'user_id' => $owner->id,
            'title' => 'Masaje relajante',
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $this->actingAs($owner)
            ->postJson(route('favorites.toggle', $ad))
            ->assertOk()
            ->assertJson(['favorited' => true]);

        $this->assertDatabaseCount('app_notifications', 0);
    }

    public function test_marking_notification_as_read_sets_read_at(): void
    {
        $user = User::factory()->create();

        $notification = AppNotification::query()->create([
            'user_id' => $user->id,
            'type' => AppNotification::TYPE_MESSAGE,
            'data' => [
                'actor_name' => 'Ana',
                'ad_title' => 'Masaje relajante',
                'url' => route('messages'),
            ],
        ]);

        $this->actingAs($user)
            ->post(route('notifications.read', $notification))
            ->assertRedirect(route('messages'));

        $this->assertNotNull($notification->fresh()->read_at);
        $this->assertSame(0, $user->fresh()->unreadNotificationsCount());
    }

    public function test_mark_all_notifications_as_read_clears_unread_count(): void
    {
        $user = User::factory()->create();

        AppNotification::query()->create([
            'user_id' => $user->id,
            'type' => AppNotification::TYPE_MESSAGE,
            'data' => ['actor_name' => 'Ana', 'ad_title' => 'Test', 'url' => route('messages')],
        ]);

        AppNotification::query()->create([
            'user_id' => $user->id,
            'type' => AppNotification::TYPE_FAVORITE,
            'data' => ['actor_name' => 'Marco', 'ad_title' => 'Test', 'url' => route('my-ads')],
        ]);

        $this->assertSame(2, $user->unreadNotificationsCount());

        $this->actingAs($user)
            ->from(route('favorites'))
            ->post(route('notifications.read-all'))
            ->assertRedirect(route('favorites'));

        $this->assertSame(0, $user->fresh()->unreadNotificationsCount());
        $this->assertSame(2, AppNotification::query()->whereNotNull('read_at')->count());
    }

    public function test_user_cannot_read_another_users_notification(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $notification = AppNotification::query()->create([
            'user_id' => $other->id,
            'type' => AppNotification::TYPE_MESSAGE,
            'data' => [
                'actor_name' => 'Ana',
                'ad_title' => 'Masaje relajante',
                'url' => route('messages'),
            ],
        ]);

        $this->actingAs($user)
            ->post(route('notifications.read', $notification))
            ->assertForbidden();
    }

    public function test_user_can_delete_own_notification(): void
    {
        $user = User::factory()->create();

        $notification = AppNotification::query()->create([
            'user_id' => $user->id,
            'type' => AppNotification::TYPE_MESSAGE,
            'data' => [
                'actor_name' => 'Ana',
                'ad_title' => 'Masaje relajante',
                'url' => route('messages'),
            ],
        ]);

        $this->actingAs($user)
            ->from(route('favorites'))
            ->delete(route('notifications.destroy', $notification))
            ->assertRedirect(route('favorites'));

        $this->assertDatabaseMissing('app_notifications', [
            'id' => $notification->id,
        ]);
    }

    public function test_user_cannot_delete_another_users_notification(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        $notification = AppNotification::query()->create([
            'user_id' => $other->id,
            'type' => AppNotification::TYPE_MESSAGE,
            'data' => [
                'actor_name' => 'Ana',
                'ad_title' => 'Masaje relajante',
                'url' => route('messages'),
            ],
        ]);

        $this->actingAs($user)
            ->delete(route('notifications.destroy', $notification))
            ->assertForbidden();

        $this->assertDatabaseHas('app_notifications', [
            'id' => $notification->id,
        ]);
    }
}
