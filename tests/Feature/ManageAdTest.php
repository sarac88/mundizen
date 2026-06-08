<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ManageAdTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_edit_form_for_own_ad(): void
    {
        $user = User::factory()->create();
        $ad = Ad::query()->create([
            'user_id' => $user->id,
            'title' => 'Mi masaje',
            'status' => Ad::STATUS_DRAFT,
        ]);

        $response = $this->actingAs($user)->get(route('ads.edit', $ad));

        $response->assertOk();
        $response->assertSee('Actualiza tu');
        $response->assertSee('Mi masaje', false);
    }

    public function test_user_cannot_edit_another_users_ad(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $ad = Ad::query()->create([
            'user_id' => $owner->id,
            'title' => 'Anuncio ajeno',
            'status' => Ad::STATUS_DRAFT,
        ]);

        $response = $this->actingAs($other)->get(route('ads.edit', $ad));

        $response->assertForbidden();
    }

    public function test_user_can_update_own_ad_without_reuploading_photos(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $ad = Ad::query()->create([
            'user_id' => $user->id,
            'category' => 'manuales',
            'title' => 'Título original',
            'description' => 'Descripción',
            'mode' => 'presencial',
            'city' => 'Valencia',
            'price_unit' => 'por_sesion',
            'price' => 45,
            'duration' => 60,
            'status' => Ad::STATUS_PUBLISHED,
            'terms_accepted' => true,
        ]);

        $path = UploadedFile::fake()->image('existing.jpg')->store("ads/{$ad->id}", 'public');
        $ad->photos()->create(['path' => $path, 'sort_order' => 0]);

        $response = $this->actingAs($user)->put(route('ads.update', $ad), [
            'action' => 'publish',
            'category' => $ad->category,
            'title' => 'Título actualizado',
            'description' => $ad->description,
            'mode' => $ad->mode,
            'city' => $ad->city,
            'price_unit' => $ad->price_unit,
            'price' => $ad->price,
            'duration' => $ad->duration,
        ]);

        $response->assertRedirect(route('my-ads'));
        $this->assertDatabaseHas('ads', [
            'id' => $ad->id,
            'title' => 'Título actualizado',
            'status' => 'published',
        ]);
        $this->assertCount(1, $ad->fresh()->photos);
    }

    public function test_user_can_pause_published_ad_to_draft(): void
    {
        $user = User::factory()->create();
        $ad = Ad::query()->create([
            'user_id' => $user->id,
            'title' => 'Anuncio activo',
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $response = $this->actingAs($user)
            ->patchJson(route('ads.status', $ad));

        $response->assertOk()->assertJson([
            'ok' => true,
            'status' => Ad::STATUS_DRAFT,
        ]);
        $this->assertDatabaseHas('ads', [
            'id' => $ad->id,
            'status' => Ad::STATUS_DRAFT,
        ]);
    }

    public function test_user_can_publish_draft_ad(): void
    {
        $user = User::factory()->create();
        $ad = Ad::query()->create([
            'user_id' => $user->id,
            'title' => 'Borrador',
            'status' => Ad::STATUS_DRAFT,
        ]);

        $response = $this->actingAs($user)
            ->patchJson(route('ads.status', $ad));

        $response->assertOk()->assertJson([
            'ok' => true,
            'status' => Ad::STATUS_PUBLISHED,
        ]);
        $this->assertDatabaseHas('ads', [
            'id' => $ad->id,
            'status' => Ad::STATUS_PUBLISHED,
        ]);
    }

    public function test_user_cannot_toggle_status_of_another_users_ad(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $ad = Ad::query()->create([
            'user_id' => $owner->id,
            'title' => 'Anuncio ajeno',
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $response = $this->actingAs($other)->patch(route('ads.status', $ad));

        $response->assertForbidden();
        $this->assertDatabaseHas('ads', [
            'id' => $ad->id,
            'status' => Ad::STATUS_PUBLISHED,
        ]);
    }

    public function test_user_can_delete_own_ad(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $ad = Ad::query()->create([
            'user_id' => $user->id,
            'title' => 'Para eliminar',
            'status' => Ad::STATUS_DRAFT,
        ]);
        $path = UploadedFile::fake()->image('photo.jpg')->store("ads/{$ad->id}", 'public');
        $ad->photos()->create(['path' => $path, 'sort_order' => 0]);

        $response = $this->actingAs($user)
            ->deleteJson(route('ads.destroy', $ad));

        $response->assertOk()->assertJson(['ok' => true]);
        $this->assertDatabaseMissing('ads', ['id' => $ad->id]);
        Storage::disk('public')->assertMissing($path);
    }

    public function test_user_cannot_delete_another_users_ad(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $ad = Ad::query()->create([
            'user_id' => $owner->id,
            'title' => 'Anuncio ajeno',
            'status' => Ad::STATUS_DRAFT,
        ]);

        $response = $this->actingAs($other)->delete(route('ads.destroy', $ad));

        $response->assertForbidden();
        $this->assertDatabaseHas('ads', ['id' => $ad->id]);
    }
}
