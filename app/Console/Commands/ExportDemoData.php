<?php

namespace App\Console\Commands;

use App\Models\User;
use Database\Seeders\SeedAssets;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

/**
 * Congela el contenido actual de la base de datos como datos de seed.
 *
 * Flujo previsto: retocas la demo desde la propia aplicación en local,
 * ejecutas este comando y commiteas el resultado. A partir de ahí cualquier
 * `migrate:fresh --seed` reproduce exactamente ese estado.
 */
class ExportDemoData extends Command
{
    protected $signature = 'demo:export';

    protected $description = 'Exporta usuarios, anuncios e imágenes actuales como datos de seed';

    /** Hash de contenido => ruta del asset, para no duplicar imágenes. */
    private array $assetsByHash = [];

    public function handle(): int
    {
        $this->indexExistingAssets();

        $users = User::with(['ads' => fn ($q) => $q->orderBy('id'), 'ads.photos'])
            ->orderBy('id')
            ->get();

        if ($users->isEmpty()) {
            $this->error('No hay usuarios en la base de datos. Nada que exportar.');

            return self::FAILURE;
        }

        $data = ['users' => $users->map(fn (User $user) => $this->exportUser($user))->all()];

        $file = database_path('seeders/data/demo.json');
        @mkdir(dirname($file), 0755, true);
        file_put_contents(
            $file,
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)."\n"
        );

        $ads = $users->sum(fn (User $user) => $user->ads->count());
        $photos = $users->sum(fn (User $user) => $user->ads->sum(fn ($ad) => $ad->photos->count()));

        $this->info("✓ Exportados {$users->count()} usuarios, {$ads} anuncios y {$photos} fotos.");
        $this->line('  '.str_replace(base_path().'/', '', $file));

        return self::SUCCESS;
    }

    private function exportUser(User $user): array
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'city' => $user->city,
            'phone' => $user->phone,
            'website' => $user->website,
            'bio' => $user->bio,
            'languages' => $user->languages,
            'avatar' => $this->resolveAsset($user->avatar_path, 'avatars'),
            'ads' => $user->ads->map(fn ($ad) => [
                'category' => $ad->category,
                'title' => $ad->title,
                'description' => $ad->description,
                'certifications' => $ad->certifications,
                'mode' => $ad->mode,
                'city' => $ad->city,
                'address' => $ad->address,
                'availability' => $ad->availability,
                'price_unit' => $ad->price_unit,
                'price' => $ad->price,
                'duration' => $ad->duration,
                'status' => $ad->status,
                'views_count' => $ad->views_count,
                'photos' => $ad->photos
                    ->map(fn ($photo) => $this->resolveAsset($photo->path, "ads/{$ad->category}"))
                    ->filter()
                    ->values()
                    ->all(),
            ])->all(),
        ];
    }

    private function indexExistingAssets(): void
    {
        $base = SeedAssets::basePath();
        $files = glob($base.'{ads/*,avatars}/*.{jpg,jpeg,png,webp}', GLOB_BRACE) ?: [];

        foreach ($files as $file) {
            $this->assetsByHash[md5_file($file)] = str_replace($base, '', $file);
        }
    }

    /**
     * Devuelve la ruta en assets de una imagen de storage, copiándola si es nueva.
     */
    private function resolveAsset(?string $storagePath, string $directory): ?string
    {
        if (! $storagePath) {
            return null;
        }

        $disk = Storage::disk('public');

        if (! $disk->exists($storagePath)) {
            $this->warn("  ⚠ Falta en storage: {$storagePath}");

            return null;
        }

        $contents = $disk->get($storagePath);
        $hash = md5($contents);

        if (isset($this->assetsByHash[$hash])) {
            return $this->assetsByHash[$hash];
        }

        $asset = $this->nextAssetName($directory, pathinfo($storagePath, PATHINFO_EXTENSION) ?: 'jpg');
        $target = SeedAssets::basePath($asset);
        @mkdir(dirname($target), 0755, true);
        file_put_contents($target, $contents);

        $this->assetsByHash[$hash] = $asset;
        $this->line("  + nueva imagen: {$asset}");

        return $asset;
    }

    private function nextAssetName(string $directory, string $extension): string
    {
        $existing = SeedAssets::list($directory);
        $numbers = array_map(fn (string $name) => (int) pathinfo($name, PATHINFO_FILENAME), $existing);
        $next = $numbers === [] ? 1 : max($numbers) + 1;

        return sprintf('%s/%02d.%s', $directory, $next, $extension);
    }
}
