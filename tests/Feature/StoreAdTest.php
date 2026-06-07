<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StoreAdTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_store_ads(): void
    {
        $response = $this->post(route('ads.store'), [
            'action' => 'draft',
            'title' => 'Masaje sueco',
        ]);

        $response->assertRedirect(route('login'));
    }

    public function test_authenticated_user_can_save_draft_with_minimal_data(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('ads.store'), [
            'action' => 'draft',
            'title' => 'Masaje sueco de 60 min',
        ]);

        $response->assertRedirect(route('my-ads'));
        $response->assertSessionHas('status');

        $this->assertDatabaseHas('ads', [
            'user_id' => $user->id,
            'title' => 'Masaje sueco de 60 min',
            'status' => 'draft',
        ]);
    }

    public function test_authenticated_user_can_publish_ad_with_photos(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('ads.store'), [
            'action' => 'publish',
            'category' => 'manuales',
            'title' => 'Masaje sueco de 60 min en estudio céntrico',
            'description' => 'Sesión relajante con aceite tibio.',
            'mode' => 'presencial',
            'city' => 'Valencia',
            'address' => 'Ruzafa',
            'availability' => ['L', 'M', 'X'],
            'price_unit' => 'por_sesion',
            'price' => 45,
            'duration' => 60,
            'terms' => '1',
            'photos' => [
                UploadedFile::fake()->image('principal.jpg'),
            ],
        ]);

        $response->assertRedirect(route('my-ads'));

        $ad = Ad::query()->where('user_id', $user->id)->first();

        $this->assertNotNull($ad);
        $this->assertSame('published', $ad->status);
        $this->assertSame('manuales', $ad->category);
        $this->assertCount(1, $ad->photos);

        Storage::disk('public')->assertExists($ad->photos->first()->path);
    }

    public function test_publish_requires_mandatory_fields(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('ads.store'), [
            'action' => 'publish',
            'title' => 'Solo título',
        ]);

        $response->assertSessionHasErrors(['category', 'mode', 'price_unit', 'price', 'duration', 'photos', 'terms']);
        $this->assertDatabaseCount('ads', 0);
    }
}
