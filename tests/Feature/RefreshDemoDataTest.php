<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\AdPhoto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RefreshDemoDataTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // El comando borra carpetas enteras del disco público; con un disco
        // falso los tests no tocan las imágenes reales de desarrollo.
        Storage::fake('public');
    }

    public function test_it_removes_content_left_by_visitors(): void
    {
        $visitor = User::factory()->create(['email' => 'visitante@example.com']);
        Ad::factory()->for($visitor)->create(['title' => 'Anuncio de prueba de un visitante']);

        $this->artisan('demo:refresh --force')->assertSuccessful();

        $this->assertDatabaseMissing('users', ['email' => 'visitante@example.com']);
        $this->assertDatabaseMissing('ads', ['title' => 'Anuncio de prueba de un visitante']);
    }

    public function test_it_restores_the_frozen_demo_content(): void
    {
        $this->artisan('demo:refresh --force')->assertSuccessful();

        $fixture = json_decode(file_get_contents(database_path('seeders/data/demo.json')), true);
        $expectedUsers = count($fixture['users']);
        $expectedAds = array_sum(array_map(fn ($user) => count($user['ads']), $fixture['users']));

        $this->assertSame($expectedUsers, User::count());
        $this->assertSame($expectedAds, Ad::count());
        $this->assertSame($expectedAds, Ad::whereNotNull('title')->count());
    }

    public function test_it_is_repeatable_without_duplicating_content(): void
    {
        $this->artisan('demo:refresh --force')->assertSuccessful();
        $users = User::count();
        $ads = Ad::count();

        $this->artisan('demo:refresh --force')->assertSuccessful();

        $this->assertSame($users, User::count());
        $this->assertSame($ads, Ad::count());
    }

    public function test_it_deletes_images_uploaded_during_the_demo(): void
    {
        Storage::disk('public')->put('ads/999/photo_0.jpg', 'subida por un visitante');

        $this->artisan('demo:refresh --force')->assertSuccessful();

        Storage::disk('public')->assertMissing('ads/999/photo_0.jpg');
    }

    public function test_every_restored_photo_exists_on_disk(): void
    {
        $this->artisan('demo:refresh --force')->assertSuccessful();

        $this->assertGreaterThan(0, AdPhoto::count());

        foreach (AdPhoto::pluck('path') as $path) {
            Storage::disk('public')->assertExists($path);
        }
    }
}
