<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-3xl font-racing uppercase tracking-wider text-white">Crear Cuenta</h2>
        <p class="text-gray-400 text-sm mt-2">Únete al Conejo Club para acceder a los mejores beneficios</p>
    </div>

    @if(isset($pendingSubscription) && $pendingSubscription)
        <div class="mb-6 p-4 rounded-xl bg-green-500/10 border border-green-500/40 text-left">
            <div class="flex items-center gap-2 text-green-400 font-racing uppercase tracking-wider text-lg mb-1">
                <span>✓ ¡Pago Confirmado! ({{ $pendingSubscription->plan_name }})</span>
            </div>
            <p class="text-xs text-gray-300 leading-relaxed">
                Completa tus datos a continuación para crear tu cuenta y vincular automáticamente tu membresía recién adquirida.
            </p>
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}">
        @csrf

        @if(isset($pendingSubscription) && $pendingSubscription)
            <input type="hidden" name="payment_token" value="{{ $pendingSubscription->claim_token }}">
        @endif

        <!-- Name -->
        <div>
            <label for="name" class="block font-medium text-sm text-gray-300">Nombre Completo</label>
            <input id="name" class="block mt-1 w-full bg-brand-black/50 border border-gray-600 focus:border-brand-red focus:ring focus:ring-brand-red/30 rounded-lg text-white py-2 px-3 placeholder-gray-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Ej. Juan Pérez" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-brand-red" />
        </div>

        <!-- Email Address -->
        <div class="mt-6">
            <label for="email" class="block font-medium text-sm text-gray-300">Correo Electrónico</label>
            <input id="email" class="block mt-1 w-full bg-brand-black/50 border border-gray-600 focus:border-brand-red focus:ring focus:ring-brand-red/30 rounded-lg text-white py-2 px-3 placeholder-gray-500" type="email" name="email" value="{{ old('email', $pendingSubscription->payer_email ?? '') }}" required autocomplete="username" placeholder="ejemplo@correo.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-brand-red" />
        </div>

        <!-- Birthdate (Optional) -->
        <div class="mt-6">
            <label for="birthdate" class="block font-medium text-sm text-gray-300">Fecha de Nacimiento <span class="text-xs text-gray-500 italic">(Opcional - Para felicitarte)</span></label>
            <input id="birthdate" class="block mt-1 w-full bg-brand-black/50 border border-gray-600 focus:border-brand-red focus:ring focus:ring-brand-red/30 rounded-lg text-white py-2 px-3 placeholder-gray-500" type="date" name="birthdate" :value="old('birthdate')" />
            <x-input-error :messages="$errors->get('birthdate')" class="mt-2 text-brand-red" />
        </div>

        <!-- Password -->
        <div class="mt-6" x-data="{ showPassword: false }">
            <label for="password" class="block font-medium text-sm text-gray-300">Contraseña</label>
            <div class="relative mt-1">
                <input id="password" class="block w-full bg-brand-black/50 border border-gray-600 focus:border-brand-red focus:ring focus:ring-brand-red/30 rounded-lg text-white py-2 pl-3 pr-10 placeholder-gray-500"
                                :type="showPassword ? 'text' : 'password'"
                                type="password"
                                name="password"
                                required autocomplete="new-password" placeholder="••••••••" />
                <button type="button" @click="showPassword = !showPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-white focus:outline-none transition-colors" aria-label="Mostrar u ocultar contraseña">
                    <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showPassword" style="display: none;" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-brand-red" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-6" x-data="{ showConfirmPassword: false }">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-300">Confirmar Contraseña</label>
            <div class="relative mt-1">
                <input id="password_confirmation" class="block w-full bg-brand-black/50 border border-gray-600 focus:border-brand-red focus:ring focus:ring-brand-red/30 rounded-lg text-white py-2 pl-3 pr-10 placeholder-gray-500"
                                :type="showConfirmPassword ? 'text' : 'password'"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
                <button type="button" @click="showConfirmPassword = !showConfirmPassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-white focus:outline-none transition-colors" aria-label="Mostrar u ocultar confirmación de contraseña">
                    <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg x-show="showConfirmPassword" style="display: none;" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-brand-red" />
        </div>

        <div class="flex items-center justify-between mt-8">
            <a class="text-sm text-brand-gray hover:text-white transition-colors" href="{{ route('login') }}">
                ¿Ya tienes cuenta?
            </a>

            <button type="submit" class="bg-brand-red hover:bg-brand-red-hover text-white px-8 py-2 font-racing uppercase tracking-wider text-lg transition-all duration-300 hover:scale-105 rounded-lg shadow-[0_0_15px_rgba(230,32,32,0.4)]">
                Registrarse
            </button>
        </div>
    </form>
</x-guest-layout>
