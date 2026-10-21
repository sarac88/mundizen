<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DemoLoginController extends Controller
{
    /**
     * Inicia sesión directamente con el usuario de demostración.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = User::where('email', config('demo.email'))->first();

        if (! $user) {
            return back()->withErrors([
                'email' => __('La demo no está disponible en este momento.'),
            ]);
        }

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->intended(route('my-ads'));
    }
}
