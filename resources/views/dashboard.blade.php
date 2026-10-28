<x-app-layout>
    <x-slot name="header">
        <h2 class="font-racing uppercase text-3xl tracking-widest text-white leading-tight">
            Panel Exclusivo <span class="text-brand-red">Conejo Club</span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            @if(session('success'))
                <div class="p-4 rounded-xl bg-green-500/10 border border-green-500/40 text-green-400 font-medium">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="p-4 rounded-xl bg-brand-red/10 border border-brand-red/40 text-red-400 font-medium">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Bienvenida -->
            <div class="glass-panel p-6 border-l-4 border-brand-red flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h3 class="text-xl font-bold text-white mb-2">¡Hola, {{ Auth::user()->name }}!</h3>
                    <p class="text-gray-400">Bienvenido a tu espacio privado. Aquí encontrarás todo el contenido exclusivo dependiendo de tu nivel de membresía en el Conejo Club.</p>
                </div>
                @if(Auth::user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="bg-brand-red hover:bg-brand-red-hover text-white px-6 py-3 font-racing uppercase tracking-wider text-lg transition-all duration-300 hover:scale-105 rounded-lg shadow-[0_0_20px_rgba(230,32,32,0.4)] text-center shrink-0">
                        ⚙ Ir al Panel de Administración
                    </a>
                @endif
            </div>

            <!-- Verificación de Suscripción -->
            @php
                $user = Auth::user();
                $hasActiveSubscription = $user->hasActiveSubscription(); 
                $userPlan = $user->isAdmin()
                    ? 'Administrador (Acceso Total)'
                    : ($hasActiveSubscription && $user->subscription ? $user->subscription->plan_name : 'Ninguno');
            @endphp

            @if(!$hasActiveSubscription)
                <!-- Pantalla Bloqueada (No Suscrito) -->
                <div class="glass-panel p-12 text-center relative overflow-hidden group">
                    <div class="absolute inset-0 bg-brand-red/5 z-0"></div>
                    
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-20 h-20 rounded-full bg-brand-dark border-2 border-brand-red/50 flex items-center justify-center mb-6 shadow-[0_0_30px_rgba(230,32,32,0.3)]">
                            <svg class="w-10 h-10 text-brand-red" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        
                        <h3 class="text-3xl font-racing uppercase text-white mb-4">Contenido Bloqueado</h3>
                        <p class="text-gray-400 max-w-lg mx-auto mb-8">Para acceder a videos exclusivos, detrás de escena de las carreras, y beneficios del equipo, necesitas una membresía activa del Conejo Club.</p>
                        
                        <a href="/#suscripciones" class="bg-brand-red hover:bg-brand-red-hover text-white px-8 py-3 font-racing uppercase tracking-wider text-xl transition-all duration-300 hover:scale-105 rounded-lg shadow-[0_0_20px_rgba(230,32,32,0.4)]">
                            Ver Planes de Suscripción
                        </a>

                        <!-- Recuperación manual de pago -->
                        <div class="mt-10 pt-8 border-t border-white/10 w-full max-w-md">
                            <p class="text-sm text-gray-300 font-semibold mb-1">¿Ya realizaste tu pago y cerraste la ventana?</p>
                            <p class="text-xs text-gray-400 mb-4">Ingresa tu número de operación/comprobante de Mercado Pago o el correo con el que pagaste para vincular tu membresía:</p>
                            <form action="{{ route('payment.claim') }}" method="POST" class="flex flex-col sm:flex-row gap-2">
                                @csrf
                                <input type="text" name="reference" required placeholder="Ej. 1234567890 o correo@ejemplo.com" class="flex-grow bg-brand-black/80 border border-white/20 rounded-lg px-4 py-2 text-sm text-white placeholder-gray-500 focus:border-brand-red focus:outline-none">
                                <button type="submit" class="bg-white/10 hover:bg-brand-red text-white font-racing uppercase tracking-wider px-5 py-2 rounded-lg transition-colors text-base shrink-0">
                                    Vincular Pago
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <!-- Pantalla Desbloqueada (Contenido Premium) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Tarjeta de Membresía Actual -->
                    <div class="glass-panel p-6 bg-gradient-to-br from-brand-dark to-black border-yellow-500/30">
                        <div class="text-sm text-gray-400 uppercase tracking-widest mb-1">Tu Membresía</div>
                        <div class="text-3xl font-racing text-yellow-500 uppercase">{{ $userPlan }}</div>
                        <div class="mt-4 text-sm text-gray-300">
                            Estado: <span class="text-green-400 font-bold">Activa</span>
                        </div>
                    </div>

                    <!-- Contenido Exclusivo 1 -->
                    <div class="glass-panel overflow-hidden md:col-span-2 relative group cursor-pointer">
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-110" style="background-image: url('https://images.unsplash.com/photo-1541443131876-44b03de101c5?q=80&w=1000&auto=format&fit=crop');"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-black via-black/80 to-transparent"></div>
                        
                        <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <div class="w-16 h-16 rounded-full bg-brand-red/90 flex items-center justify-center pl-1 shadow-[0_0_30px_rgba(230,32,32,0.6)]">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </div>

                        <div class="absolute bottom-0 left-0 w-full p-6">
                            <div class="inline-block px-3 py-1 bg-brand-red text-white text-xs font-bold uppercase tracking-wider rounded-md mb-2">Exclusivo Oro</div>
                            <h4 class="text-2xl font-racing text-white uppercase tracking-wide">Detrás de escena: Preparación F4</h4>
                            <p class="text-sm text-gray-300 mt-1">Acompáñame en mi rutina de entrenamiento antes del Gran Premio.</p>
                        </div>
                    </div>
                </div>
            @endif
            
        </div>
    </div>
</x-app-layout>
