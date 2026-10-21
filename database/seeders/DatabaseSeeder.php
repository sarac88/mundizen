<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\AdPhoto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Reconstruye la demo a partir de database/seeders/data/demo.json.
 *
 * El fixture y las imágenes de database/seeders/assets están versionados, así
 * que un `migrate:fresh --seed` devuelve siempre exactamente el mismo estado.
 * Para congelar cambios hechos desde la aplicación: `php artisan demo:export`.
 */
class DatabaseSeeder extends Seeder
{
    /** Contraseña de todos los usuarios de la demo. */
    private const PASSWORD = 'password';

    public function run(): void
    {
        $data = $this->loadFixture();

        if ($data === null) {
            return;
        }

        foreach ($data['users'] ?? [] as $userData) {
            $user = $this->createUser($userData);

            if ($user->ads()->exists()) {
                continue;
            }

            foreach ($userData['ads'] ?? [] as $adData) {
                $this->createAd($user, $adData);
            }
        }

        $this->command?->info('✓ Seed completo: '.User::count().' usuarios y '.Ad::count().' anuncios.');
    }

    private function loadFixture(): ?array
    {
        $file = database_path('seeders/data/demo.json');

        if (! is_file($file)) {
            $this->command?->error("No existe {$file}. Genéralo con: php artisan demo:export");

            return null;
        }

        $data = json_decode(file_get_contents($file), true);

        if (! is_array($data)) {
            $this->command?->error("El fixture {$file} no es JSON válido.");

            return null;
        }

        return $data;
    }

    private function createUser(array $data): User
    {
        $user = User::firstOrCreate(
            ['email' => $data['email']],
            [
                'name' => $data['name'],
                'password' => Hash::make(self::PASSWORD),
                'email_verified_at' => now(),
                'city' => $data['city'] ?? null,
                'phone' => $data['phone'] ?? null,
                'website' => $data['website'] ?? null,
                'bio' => $data['bio'] ?? null,
                'languages' => $data['languages'] ?? null,
            ]
        );

        if (! $user->avatar_path && ! empty($data['avatar'])) {
            $path = "avatars/user_{$user->id}.jpg";

            if (SeedAssets::copyToPublic($data['avatar'], $path)) {
                $user->update(['avatar_path' => $path]);
            } else {
                $this->command?->warn("  ⚠ Falta el asset {$data['avatar']}");
            }
        }

        return $user;
    }

    private function createAd(User $user, array $data): void
    {
        $ad = $user->ads()->create([
            'category' => $data['category'] ?? null,
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'certifications' => $data['certifications'] ?? null,
            'mode' => $data['mode'] ?? null,
            'city' => $data['city'] ?? null,
            'address' => $data['address'] ?? null,
            'availability' => $data['availability'] ?? null,
            'price_unit' => $data['price_unit'] ?? null,
            'price' => $data['price'] ?? null,
            'duration' => $data['duration'] ?? null,
            'status' => $data['status'] ?? Ad::STATUS_PUBLISHED,
            'views_count' => $data['views_count'] ?? 0,
            'terms_accepted' => true,
        ]);

        foreach (array_values($data['photos'] ?? []) as $order => $asset) {
            $path = "ads/{$ad->id}/photo_{$order}.".(pathinfo($asset, PATHINFO_EXTENSION) ?: 'jpg');

            if (! SeedAssets::copyToPublic($asset, $path)) {
                $this->command?->warn("  ⚠ Falta el asset {$asset}");

                continue;
            }

            AdPhoto::create([
                'ad_id' => $ad->id,
                'path' => $path,
                'sort_order' => $order,
            ]);
        }
    }
}
