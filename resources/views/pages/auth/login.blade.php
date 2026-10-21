<x-layouts::auth :title="__('Log in')">
    @php($showLoginForm = ! app()->isProduction())

    <div class="flex flex-col gap-6">
        <x-auth-header
            :title="__('Log in to your account')"
            :description="$showLoginForm
                ? __('Enter your email and password below to log in')
                : __('Prueba la demo y explora la aplicación con una cuenta de ejemplo')"
        />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <!-- Demo access -->
        <form method="POST" action="{{ route('demo-login') }}" class="flex flex-col gap-2">
            @csrf

            <flux:button variant="primary" type="submit" class="w-full" data-test="demo-login-button">
                {{ __('Probar demo') }}
            </flux:button>

            <p class="text-sm text-center text-zinc-600 dark:text-zinc-400">
                {{ __('Sin registro. Entrarás con una cuenta de ejemplo.') }}
            </p>
        </form>

        @if ($showLoginForm)
        <flux:separator :text="__('o')" />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
            @csrf

            <!-- Email Address -->
            <flux:input
                name="email"
                :label="__('Email address')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('Forgot your password?') }}
                    </flux:link>
                @endif
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="filled" type="submit" class="w-full" data-test="login-button">
                    {{ __('Log in') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="space-x-1 text-sm text-center rtl:space-x-reverse text-zinc-600 dark:text-zinc-400">
                <span>{{ __('Don\'t have an account?') }}</span>
                <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
            </div>
        @endif
        @endif
    </div>
</x-layouts::auth>
