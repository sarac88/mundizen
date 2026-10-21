<?php

namespace App\Console\Commands;

use Database\Seeders\DatabaseSeeder;
use Illuminate\Console\Command;
use Illuminate\Console\ConfirmableTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

/**
 * Devuelve la demo al contenido congelado en database/seeders/data/demo.json.
 *
 * La demo es pública y cualquiera puede publicar anuncios, enviar mensajes o
 * subir fotos. Este comando borra todo lo que hayan dejado los visitantes y
 * reconstruye el estado original, para que quien entre mañana encuentre la
 * demo como se congeló con `demo:export`.
 *
 * Se ejecuta en cada despliegue y cada noche desde el planificador.
 */
class RefreshDemoData extends Command
{
    use ConfirmableTrait;

    protected $signature = 'demo:refresh {--force : Ejecutar sin confirmación en producción}';

    protected $description = 'Borra el contenido de la demo y lo reconstruye desde los datos de seed';

    /**
     * Tablas que se vacían. El resto (migrations, cache, jobs) no es contenido
     * de la demo y debe sobrevivir al reseteo.
     *
     * @var array<int, string>
     */
    private const TABLES = [
        'app_notifications',
        'messages',
        'conversations',
        'favorites',
        'ad_photos',
        'ads',
        'sessions',
        'password_reset_tokens',
        'users',
    ];

    /** Carpetas del disco público que se regeneran desde los assets del seed. */
    private const STORAGE_DIRECTORIES = ['ads', 'avatars'];

    public function handle(): int
    {
        if (! $this->confirmToProceed()) {
            return self::FAILURE;
        }

        $this->truncateTables();
        $this->clearStorage();

        $this->call('db:seed', ['--class' => DatabaseSeeder::class, '--force' => true]);

        return self::SUCCESS;
    }

    private function truncateTables(): void
    {
        Schema::disableForeignKeyConstraints();

        foreach (self::TABLES as $table) {
            if (Schema::hasTable($table)) {
                DB::table($table)->truncate();
            }
        }

        Schema::enableForeignKeyConstraints();

        $this->line('  Tablas de contenido vaciadas.');
    }

    /**
     * Borra las imágenes subidas durante la demo. El seeder vuelve a copiar
     * las originales desde database/seeders/assets.
     */
    private function clearStorage(): void
    {
        $disk = Storage::disk('public');

        foreach (self::STORAGE_DIRECTORIES as $directory) {
            $disk->deleteDirectory($directory);
        }

        $this->line('  Imágenes subidas eliminadas.');
    }
}
