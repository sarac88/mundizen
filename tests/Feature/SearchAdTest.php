<?php

namespace Tests\Feature;

use App\Models\Ad;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SearchAdTest extends TestCase
{
    use RefreshDatabase;

    public function test_search_page_lists_only_published_ads(): void
    {
        $user = User::factory()->create();

        $published = Ad::query()->create([
            'user_id' => $user->id,
            'category' => 'manuales',
            'title' => 'Masaje sueco publicado',
            'description' => 'Sesión relajante',
            'mode' => 'presencial',
            'city' => 'Valencia',
            'price_unit' => 'por_sesion',
            'price' => 45,
            'duration' => 60,
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        Ad::query()->create([
            'user_id' => $user->id,
            'title' => 'Borrador oculto',
            'status' => Ad::STATUS_DRAFT,
        ]);

        $response = $this->get(route('search'));

        $response->assertOk();
        $response->assertSee('Masaje sueco publicado');
        $response->assertDontSee('Borrador oculto');
        $response->assertSee('1', false);
    }

    public function test_search_filters_by_category_and_query(): void
    {
        $user = User::factory()->create();

        Ad::query()->create([
            'user_id' => $user->id,
            'category' => 'manuales',
            'title' => 'Masaje sueco',
            'mode' => 'presencial',
            'city' => 'Valencia',
            'price' => 45,
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        Ad::query()->create([
            'user_id' => $user->id,
            'category' => 'energeticas',
            'title' => 'Reiki online',
            'mode' => 'online',
            'city' => 'Barcelona',
            'price' => 30,
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $this->get(route('search', ['category' => 'manuales']))
            ->assertOk()
            ->assertSee('Masaje sueco')
            ->assertDontSee('Reiki online');

        $this->get(route('search', ['q' => 'reiki']))
            ->assertOk()
            ->assertSee('Reiki online')
            ->assertDontSee('Masaje sueco');
    }

    public function test_search_filters_by_city_mode_and_max_price(): void
    {
        $user = User::factory()->create();

        Ad::query()->create([
            'user_id' => $user->id,
            'title' => 'Anuncio caro Valencia',
            'mode' => 'presencial',
            'city' => 'Valencia',
            'price' => 80,
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        Ad::query()->create([
            'user_id' => $user->id,
            'title' => 'Anuncio barato online',
            'mode' => 'online',
            'city' => 'Madrid',
            'price' => 25,
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $this->get(route('search', ['city' => 'Valencia']))
            ->assertOk()
            ->assertSee('Anuncio caro Valencia')
            ->assertDontSee('Anuncio barato online');

        $this->get(route('search', ['mode' => 'online']))
            ->assertOk()
            ->assertSee('Anuncio barato online')
            ->assertDontSee('Anuncio caro Valencia');

        $this->get(route('search', ['max_price' => 30]))
            ->assertOk()
            ->assertSee('Anuncio barato online')
            ->assertDontSee('Anuncio caro Valencia');
    }

    public function test_search_sorts_by_price(): void
    {
        $user = User::factory()->create();

        Ad::query()->create([
            'user_id' => $user->id,
            'title' => 'Servicio caro',
            'price' => 90,
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        Ad::query()->create([
            'user_id' => $user->id,
            'title' => 'Servicio barato',
            'price' => 20,
            'status' => Ad::STATUS_PUBLISHED,
        ]);

        $response = $this->get(route('search', ['sort' => 'price_asc']));

        $response->assertOk();
        $this->assertLessThan(
            strpos($response->getContent(), 'Servicio caro'),
            strpos($response->getContent(), 'Servicio barato'),
        );
    }
}
