<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowAdTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_ad_listing_page_loads(): void
    {
        $user = User::factory()->create();

        $ad = Ad::query()->create([
            'user_id' => $user->id,
            'category' => 'manuales',
            'title' => 'Masaje sueco de 60 min',
            'description' => 'Sesión relajante con aceite tibio.',
            'certifications' => ['Quiromasaje (CGS)'],
            'mode' => 'presencial',
            'city' => 'Valencia',
            'address' => 'Ruzafa',
            'availability' => ['L', 'M', 'X'],
            'price_unit' => 'por_sesion',
            'price' => 45,
            'duration' => 60,
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $response = $this->get(route('listing', $ad));

        $response->assertOk();
        $response->assertSee('Masaje sueco de 60 min');
        $response->assertSee('Sesión relajante con aceite tibio.');
        $response->assertSee($user->name);
        $response->assertSee('Quiromasaje (CGS)');
        $response->assertSee('Verificado');
        $response->assertSee('Me interesa: Masaje sueco de 60 min');
    }

    public function test_draft_ad_returns_404(): void
    {
        $user = User::factory()->create();

        $ad = Ad::query()->create([
            'user_id' => $user->id,
            'title' => 'Borrador privado',
            'status' => Ad::STATUS_DRAFT,
        ]);

        $this->get(route('listing', $ad))->assertNotFound();
    }

    public function test_related_ads_from_same_category_are_shown(): void
    {
        $user = User::factory()->create();

        $main = Ad::query()->create([
            'user_id' => $user->id,
            'category' => 'manuales',
            'title' => 'Masaje principal',
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        Ad::query()->create([
            'user_id' => $user->id,
            'category' => 'manuales',
            'title' => 'Reflexología relacionada',
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        Ad::query()->create([
            'user_id' => $user->id,
            'category' => 'energeticas',
            'title' => 'Reiki no relacionado',
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $response = $this->get(route('listing', $main));

        $response->assertOk();
        $response->assertSee('Reflexología relacionada');
        $response->assertDontSee('Reiki no relacionado');
    }
}
