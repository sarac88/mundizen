<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_toggle_favorite(): void
    {
        $user = User::factory()->create();

        $ad = Ad::query()->create([
            'user_id' => $user->id,
            'title' => 'Anuncio publicado',
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $this->postJson(route('favorites.toggle', $ad))
            ->assertUnauthorized();
    }

    public function test_authenticated_user_can_toggle_favorite(): void
    {
        $owner = User::factory()->create();
        $user = User::factory()->create();

        $ad = Ad::query()->create([
            'user_id' => $owner->id,
            'title' => 'Anuncio publicado',
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $this->actingAs($user)
            ->postJson(route('favorites.toggle', $ad))
            ->assertOk()
            ->assertJson(['favorited' => true, 'count' => 1]);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'ad_id' => $ad->id,
        ]);

        $this->actingAs($user)
            ->postJson(route('favorites.toggle', $ad))
            ->assertOk()
            ->assertJson(['favorited' => false, 'count' => 0]);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'ad_id' => $ad->id,
        ]);
    }

    public function test_favorites_page_lists_saved_published_ads(): void
    {
        $owner = User::factory()->create();
        $user = User::factory()->create();

        $published = Ad::query()->create([
            'user_id' => $owner->id,
            'title' => 'Masaje favorito',
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $draft = Ad::query()->create([
            'user_id' => $owner->id,
            'title' => 'Borrador favorito',
            'status' => Ad::STATUS_DRAFT,
        ]);

        $user->favorites()->attach([$published->id, $draft->id]);

        $response = $this->actingAs($user)->get(route('favorites'));

        $response->assertOk();
        $response->assertSee('Masaje favorito');
        $response->assertDontSee('Borrador favorito');
    }

    public function test_cannot_favorite_draft_ad(): void
    {
        $owner = User::factory()->create();
        $user = User::factory()->create();

        $ad = Ad::query()->create([
            'user_id' => $owner->id,
            'title' => 'Borrador',
            'status' => Ad::STATUS_DRAFT,
        ]);

        $this->actingAs($user)
            ->postJson(route('favorites.toggle', $ad))
            ->assertNotFound();
    }
}
