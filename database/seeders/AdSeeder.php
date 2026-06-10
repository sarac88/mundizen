<?php

namespace Database\Seeders;

use App\Models\Ad;
use App\Models\AdPhoto;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class AdSeeder extends Seeder
{
    /**
     * IDs reales de Unsplash curados por categoría.
     * Verificados manualmente: son fotos de masajes, spa, reiki, etc.
     */
    private array $photosByCategory = [
        'manuales' => [
            '1544161515-4ab6ce6db874', // masaje de espalda profesional
            '1600334129128-685c5582fd35', // masaje con aceites
            '1519823551278-64ac92734fb1', // manos masaje
            '1591343395082-e120087004b4', // camilla spa
            '1515377905703-c4788e51af15', // spa zen
            '1560750588-73207b1ef5b8', // masaje deportivo
            '1570172619644-dfd03ed5d881', // masaje relajante
            '1540555700478-4be289fbecef', // spa velas
            '1612198188060-c7c2a3b66eae', // masaje espalda
            '1596178065887-1198b6148b2b', // terapia manual
        ],
        'energeticas' => [
            '1506126613408-eca07ce68773', // meditación/reiki
            '1545389336-cf090694435e', // yoga meditación
            '1559757148-5c350d0d3c56', // energía manos
            '1593811167562-9cef47bfc4d7', // reiki manos
            '1602192509154-0b900ee1f851', // terapia energética
            '1588286840104-8957b019727f', // piedras chakras
            '1447452001526-851a1eb4bf10', // meditación zen
            '1528360983277-13d401cdc186', // masaje tailandés
            '1574482620826-2b4b4ec00ec9', // masaje shiatsu
            '1600618528240-fb9fc964b853', // piedras calientes
        ],
        'cursos' => [
            '1524178232363-1fb2b075b655', // aula formación
            '1552664730-d307ca884978', // taller práctica
            '1434030216411-0b793f4b4173', // aprendizaje grupo
            '1580582932707-520aed937b7b', // clase práctica
            '1571019614242-c5c5dee9f50b', // formación terapeuta
            '1596496181848-3091d4878b24', // taller masaje pareja
            '1513258496099-48168024aec0', // grupo formación
            '1522202176988-66273c2fd55f', // clase práctica hands-on
        ],
        'productos' => [
            '1608248543803-ba4f8c70ae0b', // aceites esenciales
            '1547592166-23ac45744acd', // productos spa
            '1556228578-8c89e6adf883', // aceites aromaterapia
            '1515377905703-c4788e51af15', // productos masaje
            '1571781926291-c33c9e36e1b8', // set aceites
            '1596462502278-27bfdc403348', // productos belleza natural
            '1612817288484-6f916006741a', // aceite masaje
            '1584308666744-4d5d9eab4b4e', // camilla plegable
        ],
    ];

    public function run(): void
    {
        $this->log('Creando fotos para anuncios existentes...');

        Ad::all()->each(function (Ad $ad): void {
            $this->attachPhotos($ad);
        });

        $this->log('✓ Fotos añadidas correctamente.');
    }

    public function createAdsForUser(User $user, int $count = 2): void
    {
        for ($i = 0; $i < $count; $i++) {
            $ad = Ad::factory()->create(['user_id' => $user->id]);
            $this->attachPhotos($ad);
        }
    }

    private function attachPhotos(Ad $ad): void
    {
        $photos = $this->photosByCategory[$ad->category] ?? $this->photosByCategory['manuales'];
        shuffle($photos);
        $selected = array_slice($photos, 0, rand(2, 4));

        foreach ($selected as $order => $unsplashId) {
            $path = "ads/{$ad->id}/photo_{$order}.jpg";

            if (! Storage::disk('public')->exists($path)) {
                $downloaded = $this->downloadUnsplash($unsplashId, $ad->id, $order);
                if (! $downloaded) {
                    continue;
                }
            }

            AdPhoto::create([
                'ad_id'      => $ad->id,
                'path'       => $path,
                'sort_order' => $order,
            ]);
        }
    }

    private function downloadUnsplash(string $id, int $adId, int $order): bool
    {
        $path = "ads/{$adId}/photo_{$order}.jpg";
        $url  = "https://images.unsplash.com/photo-{$id}?w=800&h=600&fit=crop&auto=format&q=80";

        try {
            $response = Http::timeout(15)->withOptions(['allow_redirects' => true])->get($url);

            if ($response->successful() && strlen($response->body()) > 5000) {
                Storage::disk('public')->put($path, $response->body());
                $this->log("  ✓ ads/{$adId} foto {$order}");
                return true;
            }

            $this->log("  ⚠ Respuesta vacía para {$id}");
            return false;
        } catch (\Exception $e) {
            $this->log("  ⚠ Error descargando {$id}: {$e->getMessage()}");
            return false;
        }
    }

    private function log(string $message): void
    {
        if (isset($this->command)) {
            $this->command->info($message);
        }
    }
}
