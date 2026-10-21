<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Storage;

/**
 * Acceso a las imágenes versionadas en database/seeders/assets.
 *
 * La demo se reconstruye siempre a partir de estos archivos, sin descargas
 * externas, para que un reseteo devuelva exactamente el mismo contenido.
 */
class SeedAssets
{
    public static function basePath(string $relative = ''): string
    {
        return base_path('database/seeders/assets/'.ltrim($relative, '/'));
    }

    /**
     * Nombres de archivo de imagen de una carpeta de assets, ordenados.
     *
     * @return array<int, string>
     */
    public static function list(string $directory): array
    {
        $files = glob(self::basePath($directory).'/*.{jpg,jpeg,png,webp}', GLOB_BRACE) ?: [];

        return array_values(array_map('basename', $files));
    }

    /**
     * Copia un asset al disco público. Devuelve false si el asset no existe.
     */
    public static function copyToPublic(string $asset, string $destination): bool
    {
        $source = self::basePath($asset);

        if (! is_file($source)) {
            return false;
        }

        Storage::disk('public')->put($destination, file_get_contents($source));

        return true;
    }
}
