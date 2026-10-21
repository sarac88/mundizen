<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DemoLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_demo_button_logs_in_the_demo_user(): void
    {
        $user = User::factory()->create(['email' => config('demo.email')]);

        $response = $this->post(route('demo-login'));

        $this->assertAuthenticatedAs($user);
        $response->assertRedirect(route('my-ads'));
    }

    public function test_demo_login_fails_gracefully_without_demo_user(): void
    {
        $response = $this->post(route('demo-login'));

        $this->assertGuest();
        $response->assertSessionHasErrors('email');
    }

    public function test_login_form_is_hidden_in_production(): void
    {
        $this->app['env'] = 'production';

        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertSee(__('Probar demo'));
        $response->assertDontSee('name="password"', false);
    }

    public function test_login_form_is_visible_outside_production(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertSee(__('Probar demo'));
        $response->assertSee('name="password"', false);
    }
}
