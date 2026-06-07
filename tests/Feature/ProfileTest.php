<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_edit_profile_page_shows_user_data(): void
    {
        $user = User::factory()->create([
            'name' => 'Marta Llorente',
            'email' => 'marta@example.com',
            'city' => 'Valencia',
        ]);

        $response = $this->actingAs($user)->get(route('edit-profile'));

        $response->assertOk();
        $response->assertSee('Marta Llorente', false);
        $response->assertSee('marta@example.com', false);
        $response->assertSee('Valencia', false);
    }

    public function test_user_can_update_profile_without_changing_email(): void
    {
        $user = User::factory()->create([
            'name' => 'Nombre original',
            'email' => 'original@example.com',
        ]);

        $response = $this->actingAs($user)->put(route('edit-profile.update'), [
            'name' => 'Nombre actualizado',
            'city' => 'Barcelona',
            'phone' => '+34 600 000 000',
            'website' => 'ejemplo.com',
            'bio' => 'Terapeuta con 8 años de experiencia.',
            'languages' => ['Español', 'Inglés'],
            'email' => 'hackeado@example.com',
        ]);

        $response->assertRedirect(route('edit-profile'));
        $response->assertSessionHas('status');

        $user->refresh();

        $this->assertSame('Nombre actualizado', $user->name);
        $this->assertSame('original@example.com', $user->email);
        $this->assertSame('Barcelona', $user->city);
        $this->assertSame('+34 600 000 000', $user->phone);
        $this->assertSame('ejemplo.com', $user->website);
        $this->assertSame('Terapeuta con 8 años de experiencia.', $user->bio);
        $this->assertSame(['Español', 'Inglés'], $user->languages);
    }

    public function test_user_can_upload_avatar(): void
    {
        Storage::fake('public');

        $user = User::factory()->create(['name' => 'Usuario']);

        $response = $this->actingAs($user)->put(route('edit-profile.update'), [
            'name' => 'Usuario',
            'avatar' => UploadedFile::fake()->image('avatar.jpg'),
        ]);

        $response->assertRedirect(route('edit-profile'));

        $user->refresh();

        $this->assertNotNull($user->avatar_path);
        Storage::disk('public')->assertExists($user->avatar_path);
        $this->assertNotNull($user->avatarUrl());
    }

    public function test_name_is_required(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('edit-profile.update'), [
            'name' => '',
        ]);

        $response->assertSessionHasErrors('name');
    }

    public function test_bio_cannot_exceed_300_characters(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->put(route('edit-profile.update'), [
            'name' => 'Usuario',
            'bio' => str_repeat('a', 301),
        ]);

        $response->assertSessionHasErrors('bio');
    }
}
