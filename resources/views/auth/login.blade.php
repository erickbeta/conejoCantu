<!--  --><x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-6">
        <h2 class="text-3xl font-racing uppercase tracking-wider text-white">Iniciar Sesión</h2>
    </div>

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-1 sm:gap-3 text-sm mb-5 pb-3 border-b border-white/10 text-center sm:text-left sm:whitespace-nowrap">
        <span class="text-gray-300 font-medium">Iniciar sesión con tu cuenta</span>
        <span class="text-gray-500 font-semibold italic">ó</span>
        <span class="text-gray-300 font-medium">¿Ya tienes Cuenta?</span>

        <a href="{{ route('register') }}" class="text-brand-red hover:text-white transition-colors font-bold">Regístrate</a>
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
        <div class="mt-6" x-data="{ showPassword: false }">
            <label for="password" class="block font-medium text-sm text-gray-300">Contraseña</label>
            <div class="relative mt-1">
                <input id="password" class="block w-full bg-brand-black/50 border border-gray-600 focus:border-brand-red focus:ring focus:ring-brand-red/30 rounded-lg text-white py-2 pl-3 pr-10 placeholder-gray-500"
                                :type="showPassword ? 'text' : 'password'"
                                type="password"
                                name="password"
                                required autocomplete="current-password" placeholder="••••••••" />
                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-white focus:outline-none transition-colors" aria-label="Mostrar u ocultar contraseña">
                    <!-- Ojito abierto (mostrar) -->
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <!-- Ojito tachado (ocultar) -->
                    <svg x-show="showPassword" style="display: none;" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
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
    </form>
</x-guest-layout>
