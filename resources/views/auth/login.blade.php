<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-3xl font-racing uppercase tracking-wider text-white">Iniciar Sesión</h2>
        <p class="text-gray-400 text-sm mt-2">Para unirte al Conejo Club o realizar tu aportación, necesitas iniciar sesión o crear una cuenta gratuita.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-gray-300">Correo Electrónico</label>
            <input id="email" class="block mt-1 w-full bg-brand-black/50 border border-gray-600 focus:border-brand-red focus:ring focus:ring-brand-red/30 rounded-lg text-white py-2 px-3 placeholder-gray-500" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="ejemplo@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-brand-red" />
        </div>

        <!-- Password -->
        <div class="mt-6">
            <label for="password" class="block font-medium text-sm text-gray-300">Contraseña</label>
            <input id="password" class="block mt-1 w-full bg-brand-black/50 border border-gray-600 focus:border-brand-red focus:ring focus:ring-brand-red/30 rounded-lg text-white py-2 px-3 placeholder-gray-500"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-brand-red" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-6">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-gray-600 bg-brand-black/50 text-brand-red shadow-sm focus:ring-brand-red/50 focus:ring-offset-0" name="remember">
                <span class="ms-2 text-sm text-gray-400">Recordarme</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-8">
            @if (Route::has('password.request'))
                <a class="text-sm text-brand-gray hover:text-white transition-colors" href="{{ route('password.request') }}">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif

            <button type="submit" class="bg-brand-red hover:bg-brand-red-hover text-white px-8 py-2 font-racing uppercase tracking-wider text-lg transition-all duration-300 hover:scale-105 rounded-lg shadow-[0_0_15px_rgba(230,32,32,0.4)]">
                Entrar
            </button>
        </div>
        
        <div class="mt-6 text-center text-sm text-gray-400">
            ¿No tienes cuenta? <a href="{{ route('register') }}" class="text-brand-red hover:text-white transition-colors font-bold">Regístrate aquí</a>
        </div>
    </form>
</x-guest-layout>
