<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * IDs de Unsplash de retratos de mujeres (terapeutas/profesionales).
     * Curados manualmente para que sean coherentes con el contexto.
     */
    private array $avatarIds = [
        'photo-1494790108377-be9c29b29330', // mujer sonriente profesional
        'photo-1529626455594-4ff0802cfb7e', // mujer joven profesional
        'photo-1438761681033-6461ffad8d80', // mujer retrato natural
        'photo-1508214751196-bcfd4ca60f91', // mujer terapeuta
        'photo-1544005313-94ddf0286df2', // retrato mujer
        'photo-1531746020798-e6953c6e8e04', // mujer natural
        'photo-1487412720507-e7ab37603c6f', // retrato profesional
        'photo-1499952127939-9bbf5af6c51c', // mujer zen
        'photo-1521146764736-56c929d59c83', // terapeuta
        'photo-1534528741775-53994a69daeb', // mujer joven
        'photo-1492106087820-71f1a00d2b11', // retrato cálido
        'photo-1502685104226-ee32379fefbe', // mujer profesional
    ];

    private array $bios = [
        'Sara García'    => 'Terapeuta holística con más de 10 años de experiencia. Apasionada del bienestar y la medicina natural.',
        'Laura Martínez' => 'Fisioterapeuta colegiada y masajista deportiva. Me encanta acompañar a las personas en su proceso de recuperación.',
        'Carmen Ruiz'    => 'Terapeuta ayurvédica formada en India. Creo en el poder del equilibrio cuerpo-mente para una vida plena.',
        'Ana Torres'     => 'Masajista profesional especializada en bienestar femenino. Más de 8 años cuidando a mis clientas con mimo y dedicación.',
        'Marta López'    => 'Instructora de masaje y terapeuta corporal. Me apasiona enseñar y compartir el poder sanador del tacto.',
        'Isabel Sánchez' => 'Especialista en rituales de bienestar con aromaterapia y piedras volcánicas. Cada sesión es un momento para ti.',
    ];

    public function run(): void
    {
        // ── Usuario de prueba fijo ────────────────────────────────────────────
        $testUser = User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name'              => 'Sara García',
                'password'          => Hash::make('password'),
                'email_verified_at' => now(),
                'city'              => 'Madrid',
                'bio'               => $this->bios['Sara García'],
            ]
        );
        $this->attachAvatar($testUser, 0);

        // ── Usuarios de ejemplo con datos realistas ───────────────────────────
        $users = [
            ['name' => 'Laura Martínez',  'email' => 'laura@example.com',  'city' => 'Barcelona'],
            ['name' => 'Carmen Ruiz',     'email' => 'carmen@example.com', 'city' => 'Valencia'],
            ['name' => 'Ana Torres',      'email' => 'ana@example.com',    'city' => 'Sevilla'],
            ['name' => 'Marta López',     'email' => 'marta@example.com',  'city' => 'Bilbao'],
            ['name' => 'Isabel Sánchez',  'email' => 'isabel@example.com', 'city' => 'Málaga'],
        ];

        $createdUsers = collect($users)->map(function (array $data, int $index) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                array_merge($data, [
                    'password'          => Hash::make('password'),
                    'email_verified_at' => now(),
                    'bio'               => $this->bios[$data['name']] ?? null,
                ])
            );
            $this->attachAvatar($user, $index + 1);
            return $user;
        });

        // ── Anuncios para el usuario de prueba ────────────────────────────────
        $adSeeder = new AdSeeder();

        if ($testUser->ads()->count() === 0) {
            $adSeeder->createAdsForUser($testUser, 3);
        }

        // ── Anuncios para cada usuario de ejemplo ─────────────────────────────
        foreach ($createdUsers as $user) {
            if ($user->ads()->count() === 0) {
                $adSeeder->createAdsForUser($user, rand(1, 3));
            }
        }

        // ── Usuarios aleatorios adicionales con anuncios ─────────────────────
        $randomUsers = User::factory(5)->create(['city' => fake()->randomElement([
            'Madrid', 'Barcelona', 'Valencia', 'Zaragoza', 'Murcia',
        ])]);

        foreach ($randomUsers as $index => $user) {
            $this->attachAvatar($user, $index + 6);
            $adSeeder->createAdsForUser($user, rand(1, 2));
        }

        $total = Ad::count();
        $this->command->info("✓ Seed completo: {$total} anuncios creados.");
    }

    private function attachAvatar(User $user, int $index): void
    {
        if ($user->avatar_path) {
            return;
        }

        $avatarId = $this->avatarIds[$index % count($this->avatarIds)];
        $path     = "avatars/user_{$user->id}.jpg";
        $url      = "https://images.unsplash.com/{$avatarId}?w=400&h=400&fit=crop&crop=face&auto=format&q=80";

        try {
            $response = Http::timeout(15)->withOptions(['allow_redirects' => true])->get($url);

            if ($response->successful() && strlen($response->body()) > 5000) {
                Storage::disk('public')->put($path, $response->body());
                $user->update(['avatar_path' => $path]);
                $this->command->info("  ✓ Avatar descargado para {$user->name}");
            }
        } catch (\Exception $e) {
            $this->command->warn("  ⚠ No se pudo descargar avatar para {$user->name}: {$e->getMessage()}");
        }
    }
}
