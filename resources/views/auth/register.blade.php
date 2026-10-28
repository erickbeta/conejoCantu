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
        <div class="mt-6">
            <label for="password" class="block font-medium text-sm text-gray-300">Contraseña</label>
            <input id="password" class="block mt-1 w-full bg-brand-black/50 border border-gray-600 focus:border-brand-red focus:ring focus:ring-brand-red/30 rounded-lg text-white py-2 px-3 placeholder-gray-500"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-brand-red" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-6">
            <label for="password_confirmation" class="block font-medium text-sm text-gray-300">Confirmar Contraseña</label>
            <input id="password_confirmation" class="block mt-1 w-full bg-brand-black/50 border border-gray-600 focus:border-brand-red focus:ring focus:ring-brand-red/30 rounded-lg text-white py-2 px-3 placeholder-gray-500"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
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
