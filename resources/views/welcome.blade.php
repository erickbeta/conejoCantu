<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Conejo Cantú 88 | Sitio Oficial</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;700;900&family=Teko:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Loop de Blanco y Negro a Color */
        @keyframes grayscale-loop {
            0% { filter: grayscale(100%); }
            25% { filter: grayscale(100%); } /* 2s en B&N (mitad de tiempo) */
            37.5% { filter: grayscale(0%); } /* 1s transición a color */
            87.5% { filter: grayscale(0%); } /* 4s en color */
            100% { filter: grayscale(100%); } /* 1s transición a B&N */
        }
        .animate-grayscale-loop {
            animation: grayscale-loop 8s infinite;
        }
        
        /* Efecto Racing (Drive-in / Drive-out) */
        .racing-text {
            display: inline-block;
            animation: drive-by 6s cubic-bezier(0.25, 1, 0.5, 1) infinite;
        }
        
        @keyframes drive-by {
            /* 0% - Entra a toda velocidad desde la izquierda */
            0% { 
                transform: translateX(-150%) skewX(-30deg); 
                opacity: 0; 
            }
            /* 8% - Frena pasándose un poquito de la marca */
            8% { 
                transform: translateX(5%) skewX(10deg); 
                opacity: 1; 
            }
            /* 12% - Se asienta y se "estaciona" perfectamente */
            12% { 
                transform: translateX(0) skewX(0); 
            }
            /* 12% al 75% - Se queda estacionado para que se pueda leer */
            75% { 
                transform: translateX(0) skewX(0); 
                opacity: 1;
            }
            /* 80% - Coge impulso hacia atrás como si quemara llanta */
            80% { 
                transform: translateX(-5%) skewX(-10deg); 
                opacity: 1;
            }
            /* 90% - Sale a toda velocidad hacia la derecha */
            90% { 
                transform: translateX(150%) skewX(30deg); 
                opacity: 0; 
            }
            /* 100% - Se mantiene oculto para reiniciar el ciclo */
            100% { 
                transform: translateX(150%) skewX(30deg); 
                opacity: 0; 
            }
        }
        
        /* Cursor Máquina de escribir */
        .typewriter-cursor {
            display: inline-block;
            width: 3px;
            height: 1.2em;
            background-color: var(--color-red);
            vertical-align: text-bottom;
            animation: blink 1s step-end infinite;
            margin-left: 2px;
        }
        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0; }
        }
        /* Animaciones Adicionales */
        .floating {
            animation: floating 6s ease-in-out infinite;
        }
        @keyframes floating {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-15px); }
            100% { transform: translateY(0px); }
        }

        .pulse-glow {
            animation: pulse-glow 3s infinite;
        }
        @keyframes pulse-glow {
            0% { box-shadow: 0 0 15px rgba(230,32,32,0.3); }
            50% { box-shadow: 0 0 35px rgba(230,32,32,0.6); }
            100% { box-shadow: 0 0 15px rgba(230,32,32,0.3); }
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-brand-black text-white antialiased selection:bg-brand-red selection:text-white">
    
    <!-- Barra de Progreso de Lectura -->
    <div id="reading-progress" class="fixed top-0 left-0 h-1 bg-brand-red z-[60] transition-all duration-100 w-0"></div>

    <!-- Menú de Navegación Flotante -->
    <nav class="fixed top-0 w-full z-50 bg-brand-black/80 backdrop-blur-md border-b border-white/5 transition-all duration-300" id="navbar">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/" class="flex items-center gap-3 transition-transform hover:scale-105">
                <img src="{{ asset('images/logos/conejo-color.png') }}" alt="Conejo Cantú" class="h-6 md:h-8 w-auto object-contain">
                <img src="{{ asset('images/logos/logo2.png') }}" alt="Logo 88" class="h-10 md:h-12 w-auto object-contain">
            </a>
            
            <div class="hidden md:flex items-center gap-8 font-medium">
                <a href="#biografia" class="text-gray-300 hover:text-brand-red transition-colors uppercase font-racing text-xl tracking-widest">Biografía</a>
                <a href="#merch" class="text-gray-300 hover:text-brand-red transition-colors uppercase font-racing text-xl tracking-widest">Merch</a>
                <a href="#colaboradores" class="text-gray-300 hover:text-brand-red transition-colors uppercase font-racing text-xl tracking-widest">Partners</a>
                <a href="#contacto" class="text-gray-300 hover:text-brand-red transition-colors uppercase font-racing text-xl tracking-widest">Contacto</a>
                
                @auth
                    <a href="{{ url('/dashboard') }}" class="text-gray-300 hover:text-brand-red transition-colors uppercase font-racing text-xl tracking-widest ml-4">Mi Cuenta</a>
                @else
                    <a href="{{ route('login') }}" class="text-gray-300 hover:text-brand-red transition-colors uppercase font-racing text-xl tracking-widest ml-4">Login</a>
                @endauth
                
                <!-- Redes Sociales -->
                <a href="#" onclick="openSocialModal(event)" class="transition-transform hover:scale-110 border-l border-white/20 pl-8 ml-2 flex items-center">
                    <img src="{{ asset('images/logos/redes-blanco.png') }}" alt="Redes Sociales" class="h-10 w-auto object-contain opacity-80 hover:opacity-100 transition-opacity">
                </a>

                <a href="#suscripciones" class="bg-brand-red hover:bg-brand-red-hover text-white px-8 py-2 font-racing uppercase tracking-wider text-xl transition-all duration-300 hover:scale-105 pulse-glow" style="clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%);">Unirme a Conejo Club</a>
            </div>
            
            <!-- Menú Móvil Simple -->
            <div class="md:hidden">
                <a href="#suscripciones" class="bg-brand-red text-white px-4 py-2 rounded-full text-xs uppercase font-bold tracking-wider">Unirme a Conejo Club</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <main class="relative flex-grow flex flex-col justify-center min-h-[90vh] pt-24 px-6 overflow-hidden bg-brand-black">
        <!-- Background Elements: Softer gradient -->
        <div class="absolute inset-0 bg-gradient-to-br from-brand-red/10 via-brand-black to-brand-black z-0"></div>
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/stardust.png')] opacity-20 z-0"></div>
        
        <div class="max-w-7xl mx-auto w-full grid grid-cols-1 lg:grid-cols-2 gap-8 items-center relative z-10 flex-grow">
            <!-- Text Left -->
            <div class="p-8 md:p-12 animate-fade-in-up text-left">
                <div class="inline-block px-4 py-1 border border-brand-red/50 text-brand-red font-racing text-xl mb-6 rounded-tl-lg rounded-br-lg" style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 10px), calc(100% - 10px) 100%, 0 100%);">
                    {{ $settings['hero_badge']->value ?? 'PILOTO DE FÓRMULA 3' }}
                </div>
                <div class="mb-8 mt-2">
                    <img src="{{ asset('images/logos/letrero-conejo.png') }}" alt="Conejo Cantú" class="w-full max-w-[300px] md:max-w-md object-contain filter drop-shadow-[0_0_20px_rgba(230,32,32,0.3)] mx-auto md:mx-0">
                </div>
                <p class="text-brand-gray text-xl md:text-2xl mb-10 font-light uppercase tracking-widest h-16 md:h-10">
                    <span id="typewriter-text"></span><span class="typewriter-cursor"></span>
                </p>
                <div class="flex flex-col sm:flex-row gap-6 opacity-0 translate-y-4 pt-4" id="hero-buttons" style="transition: opacity 1s ease, transform 1s ease;">
                    <a href="#suscripciones" class="group relative inline-flex items-center justify-center px-12 py-3 font-racing text-2xl uppercase tracking-wider text-white transition-all duration-300 hover:-translate-y-1 w-full sm:w-auto pulse-glow">
                        <div class="absolute inset-0 bg-brand-red skew-x-[-12deg] rounded-sm transition-all duration-300 group-hover:bg-red-700"></div>
                        <span class="relative mt-1">{{ $settings['hero_button_1_text']->value ?? 'Apoyar al Piloto' }}</span>
                    </a>
                    <a href="#biografia" class="group relative inline-flex items-center justify-center px-12 py-3 font-racing text-2xl uppercase tracking-wider text-white transition-all duration-300 hover:-translate-y-1 w-full sm:w-auto mt-2 sm:mt-0">
                        <div class="absolute inset-0 bg-white/5 border border-white/20 skew-x-[-12deg] rounded-sm transition-all duration-300 group-hover:bg-white/10"></div>
                        <span class="relative mt-1">{{ $settings['hero_button_2_text']->value ?? 'Conocer Más' }}</span>
                    </a>
                </div>
            </div>
            
            <!-- Image Placeholder Right -->
            <div class="flex justify-center items-end h-[50vh] md:h-[60vh] lg:h-[80vh] relative animate-fade-in-up mt-8 lg:mt-0" style="animation-delay: 0.3s;">
                <!-- Efecto de resplandor detrás del piloto -->
                <div class="absolute inset-0 bg-brand-red/5 blur-[100px] rounded-full z-0"></div>
                <div class="w-full h-full bg-gradient-to-t from-brand-black via-transparent to-transparent absolute bottom-0 left-0 z-20"></div>
                
                <div class="text-white/5 font-racing text-[15rem] absolute -right-10 top-10 select-none z-0 leading-none">88</div>
                
                <!-- Caja de imagen con diseño fusión (bordes redondeados + corte) -->
                <div class="w-3/4 h-5/6 border border-white/10 bg-brand-dark/30 backdrop-blur-sm rounded-2xl flex items-center justify-center relative z-10 overflow-hidden floating" style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 40px), calc(100% - 40px) 100%, 0 100%); box-shadow: inset 0 0 20px rgba(255,255,255,0.02);">
                    @if(isset($settings['hero_image']) && $settings['hero_image']->value)
                        <img src="{{ asset('storage/' . $settings['hero_image']->value) }}" alt="Cristian Cantú" class="w-full h-full object-cover animate-grayscale-loop">
                    @else
                        <img src="{{ asset('images/Cara Concentrado.jpg') }}" alt="Cristian Cantú" class="w-full h-full object-cover animate-grayscale-loop">
                    @endif
                </div>
            </div>
        </div>


    </main>

    <!-- Estadísticas (Grid de Tarjetas) y Trayectoria -->
    <section id="estadisticas" class="py-16 px-6 bg-brand-black relative z-20 border-b border-white/5">
        <div class="max-w-7xl mx-auto">
            
            <!-- Tarjetas Superiores -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12" id="stats-container">
                <!-- Tarjeta Principal (Número) -->
                <div class="bg-brand-red text-white p-6 rounded-xl flex items-center justify-center pulse-glow" style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 20px), calc(100% - 20px) 100%, 0 100%);">
                    <img src="{{ asset('images/logos/logo3-blanco.png') }}" alt="Conejo Cantú Logo" class="max-h-20 w-auto object-contain drop-shadow-md hover:scale-105 transition-transform duration-300">
                </div>
                
                <!-- Tarjetas de Stats -->
                <div class="bg-brand-dark border border-white/5 p-6 rounded-xl flex flex-col justify-center items-center hover:bg-white/5 transition-colors" style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%);">
                    <div class="text-5xl font-racing mb-1 italic text-white"><span class="counter" data-target="{{ $settings['stats_carreras']->value ?? '121' }}">0</span></div>
                    <div class="text-sm font-racing uppercase tracking-widest text-brand-red">Carreras</div>
                </div>
                <div class="bg-brand-dark border border-white/5 p-6 rounded-xl flex flex-col justify-center items-center hover:bg-white/5 transition-colors" style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%);">
                    <div class="text-5xl font-racing mb-1 italic text-white"><span class="counter" data-target="{{ $settings['stats_podios']->value ?? '78' }}">0</span></div>
                    <div class="text-sm font-racing uppercase tracking-widest text-brand-red">Podios</div>
                </div>
                <div class="bg-brand-dark border border-white/5 p-6 rounded-xl flex flex-col justify-center items-center hover:bg-white/5 transition-colors" style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 15px), calc(100% - 15px) 100%, 0 100%);">
                    <div class="text-5xl font-racing mb-1 italic text-white"><span class="counter" data-target="{{ $settings['stats_anios']->value ?? '10' }}">0</span></div>
                    <div class="text-sm font-racing uppercase tracking-widest text-brand-red">Años Exp.</div>
                </div>
            </div>

            <!-- Detalle de Trayectoria (Grid List) -->
            <div class="bg-brand-dark border border-white/5 rounded-2xl p-8 md:p-12 relative overflow-hidden shadow-2xl" style="clip-path: polygon(0 0, 100% 0, 100% calc(100% - 30px), calc(100% - 30px) 100%, 0 100%);">
                <!-- Efecto de fondo sutil -->
                <div class="absolute right-0 top-0 w-1/2 h-full bg-gradient-to-l from-brand-red/5 to-transparent z-0"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-8 border-b border-white/10 pb-6">
                        <div class="w-2 h-8 bg-brand-red rounded-sm"></div>
                        <h3 class="text-4xl font-racing uppercase tracking-widest text-white italic">Trayectoria <span class="text-brand-red">Oficial</span></h3>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
                        <!-- Columna Izquierda -->
                        <div class="space-y-6">
                            <div class="flex items-start gap-5 group">
                                <div class="text-brand-red font-racing text-4xl leading-none w-12 group-hover:scale-110 transition-transform">#1</div>
                                <div class="text-gray-300 font-light text-lg pt-1">Fórmula 4 México</div>
                            </div>
                            <div class="flex items-start gap-5 group">
                                <div class="text-brand-red font-racing text-4xl leading-none w-12 group-hover:scale-110 transition-transform">#2</div>
                                <div class="text-gray-300 font-light text-lg pt-1">Fórmula 4 Latinoamérica</div>
                            </div>
                            <div class="flex items-start gap-5 group">
                                <div class="text-brand-red font-racing text-4xl leading-none w-12 group-hover:scale-110 transition-transform">#6</div>
                                <div class="text-gray-300 font-light text-lg pt-1">MUNDIAL Fórmula 4 <span class="text-gray-500 text-sm ml-1">(Rusia)</span></div>
                            </div>
                            <div class="flex items-start gap-5 group">
                                <div class="text-brand-red font-racing text-4xl leading-none w-12 group-hover:scale-110 transition-transform">#5</div>
                                <div class="text-gray-300 font-light text-lg pt-1">Mundial e-Karting <span class="text-gray-500 text-sm ml-1">(Portugal)</span></div>
                            </div>
                        </div>

                        <!-- Columna Derecha -->
                        <div class="space-y-6">
                            <div class="flex items-start gap-5 group">
                                <div class="text-brand-red font-racing text-4xl leading-none w-12 group-hover:scale-110 transition-transform italic">3x</div>
                                <div class="text-gray-300 font-light text-lg pt-1">Campeón Nacional Karting</div>
                            </div>
                            <div class="flex items-start gap-5 group">
                                <div class="text-brand-red font-racing text-4xl leading-none w-12 group-hover:scale-110 transition-transform italic">3x</div>
                                <div class="text-gray-300 font-light text-lg pt-1">Subcampeón Nacional Karting</div>
                            </div>
                            <div class="flex items-start gap-5 group">
                                <div class="text-brand-red font-racing text-4xl leading-none w-12 group-hover:scale-110 transition-transform">🏁</div>
                                <div class="text-gray-300 font-light text-lg pt-1">
                                    3 mundiales y 2 centro-sudamericanos (#2 y #4)
                                </div>
                            </div>
                        </div>

                        <!-- Premios Especiales (Fila completa) -->
                        <div class="md:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6 mt-4 pt-8 border-t border-white/5">
                            <div class="bg-white/5 border border-white/10 rounded-xl p-6 hover:bg-white/10 transition-colors">
                                <div class="flex items-center gap-4 mb-2">
                                    <span class="text-3xl">🏆</span>
                                    <h4 class="text-xl font-racing uppercase tracking-widest text-white">Casco de Plata 2023</h4>
                                </div>
                                <p class="text-sm text-gray-400 font-light pl-[3.25rem]">Premio al mejor piloto Mexicano de Karting.</p>
                            </div>
                            
                            <div class="bg-white/5 border border-white/10 rounded-xl p-6 hover:bg-white/10 transition-colors relative overflow-hidden">
                                <div class="absolute top-0 right-0 w-16 h-16 bg-brand-red/10 rounded-full blur-xl"></div>
                                <div class="flex items-center gap-4 mb-2">
                                    <span class="text-3xl">🌎</span>
                                    <h4 class="text-xl font-racing uppercase tracking-widest text-white">FIA América Awards 2023</h4>
                                </div>
                                <p class="text-sm text-gray-400 font-light pl-[3.25rem]">Único Mexicano ganador (se entrega 1 al año). Entregado en Panamá.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Carrera Destacada (Estilo Widget Retrospectivo) -->
    <section id="carrera-destacada" class="py-20 px-6 bg-brand-black relative">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center gap-4 mb-8">
                <div class="w-2 h-8 bg-brand-red rounded-sm"></div>
                <h2 class="text-4xl md:text-5xl font-racing tracking-widest text-white uppercase italic">Carrera <span class="text-brand-red">Destacada</span></h2>
            </div>
            
            <div class="bg-brand-dark border border-brand-red/20 rounded-2xl overflow-hidden shadow-[0_0_40px_rgba(230,32,32,0.1)] relative">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-red via-brand-red/50 to-transparent"></div>
                <div class="grid grid-cols-1 md:grid-cols-3">
                    <div class="p-10 md:col-span-2 flex flex-col justify-center">
                        <div class="flex flex-wrap items-center gap-3 mb-4">
                            <div class="inline-block px-3 py-1 bg-brand-red text-white text-xs font-bold uppercase tracking-widest rounded-md w-max shadow-lg shadow-brand-red/30">{{ $featuredRace ? $featuredRace->badge : '1er Lugar' }}</div>
                            <div class="inline-block px-3 py-1 bg-white/10 text-brand-gray text-xs font-bold uppercase tracking-widest rounded-md w-max border border-white/5">{{ $featuredRace ? $featuredRace->category : 'Fórmula 4 México' }}</div>
                        </div>
                        <h3 class="text-5xl md:text-6xl font-racing text-white uppercase italic mb-2 leading-none">{{ $featuredRace ? $featuredRace->title : 'Gran Premio Fórmula 1 Ciudad de México' }}</h3>
                        <p class="text-brand-gray text-xl uppercase tracking-widest mb-6">{{ $featuredRace ? $featuredRace->location : 'Autódromo Hermanos Rodríguez' }}</p>
                        
                        <p class="text-gray-400 font-light max-w-xl mb-8">{!! $featuredRace ? nl2br(e($featuredRace->description)) : 'Una actuación histórica que consolidó a Conejo Cantú en lo más alto del podio de la <strong>Fórmula 4</strong> en el circuito más emblemático del país. Corriendo como categoría principal de soporte durante el fin de semana de la F1, Cristian demostró su talento y determinación frente a miles de aficionados al automovilismo. Saliendo desde los pits por una falla mecánica logra ganar ambas carreras.' !!}</p>
                        
                        <div class="flex flex-wrap gap-4 mb-8">
                            <div class="bg-white/5 border border-white/10 text-white font-racing text-2xl px-6 py-2 rounded-lg flex items-center gap-2"><span class="text-brand-red">{{ $featuredRace ? $featuredRace->stat1_label : 'Pos:' }}</span> {{ $featuredRace ? $featuredRace->stat1_value : 'P1' }}</div>
                            <div class="bg-white/5 border border-white/10 text-white font-racing text-2xl px-6 py-2 rounded-lg flex items-center gap-2"><span class="text-brand-red">{{ $featuredRace ? $featuredRace->stat2_label : 'V. Rápida:' }}</span> {{ $featuredRace ? $featuredRace->stat2_value : 'Récord Pista' }}</div>
                        </div>
                        
                        <!-- Imagen debajo del texto -->
                        @if($featuredRace && $featuredRace->image_path)
                            <div class="w-full border border-white/10 rounded-xl overflow-hidden relative group" style="height: 350px;">
                                <img src="{{ asset('storage/' . $featuredRace->image_path) }}" class="absolute inset-0 w-full h-full object-cover opacity-80 group-hover:scale-105 group-hover:opacity-100 transition-all duration-500" alt="Podio">
                            </div>
                        @else
                            <!-- Placeholder Foto Podio -->
                            <div class="w-full bg-black/60 border border-white/10 rounded-xl flex flex-col items-center justify-center hover:bg-black/80 transition-colors cursor-pointer group overflow-hidden relative" style="height: 350px;">
                                <div class="absolute inset-0 bg-gradient-to-tr from-yellow-500/10 via-blue-500/10 to-red-500/10 opacity-30"></div>
                                <div class="absolute inset-0 bg-gradient-to-bl from-green-500/10 via-white/10 to-red-500/10 opacity-30"></div>
                                <span class="text-6xl mb-4 group-hover:scale-110 transition-transform relative z-10">📸</span>
                                <span class="text-gray-400 text-lg font-racing uppercase tracking-widest text-center relative z-10 px-4">Foto Podio<br><span class="text-sm normal-case text-gray-500 mt-2 block">(Banderas Colombia y México)</span></span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="bg-white/5 border-l border-white/5 p-4 flex flex-col items-center justify-center relative overflow-hidden min-h-[250px] bg-[url('https://www.transparenttextures.com/patterns/carbon-fibre.png')]">
                        <!-- Red glow effect -->
                        <div class="absolute inset-0 bg-brand-red/10 mix-blend-overlay"></div>
                        
                        <div class="z-10 w-full h-full flex flex-col p-4">
                            @if($featuredRace && $featuredRace->video_path)
                                <div class="w-full h-full min-h-[300px] flex-grow border border-white/10 rounded-xl overflow-hidden bg-black shadow-[0_0_20px_rgba(0,0,0,0.5)]">
                                    <video id="featured-video" controls preload="metadata" muted playsinline class="w-full h-full object-cover">
                                        <source src="{{ asset('storage/' . $featuredRace->video_path) }}#t=0.1" type="video/mp4">
                                        Tu navegador no soporta el formato de video.
                                    </video>
                                </div>
                            @elseif($featuredRace && $featuredRace->video_url)
                                @php
                                    $isYoutube = false;
                                    $youtubeId = '';
                                    if (preg_match('/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/i', $featuredRace->video_url, $match)) {
                                        $isYoutube = true;
                                        $youtubeId = $match[1];
                                    }
                                @endphp
                                @if($isYoutube)
                                    <div class="w-full h-full min-h-[300px] flex-grow border border-white/10 rounded-xl overflow-hidden bg-black shadow-[0_0_20px_rgba(0,0,0,0.5)]">
                                        <iframe id="featured-youtube" width="100%" height="100%" src="https://www.youtube.com/embed/{{ $youtubeId }}?enablejsapi=1&mute=1" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                    </div>
                                @else
                                    <a href="{{ $featuredRace->video_url }}" target="_blank" class="w-full h-full min-h-[300px] flex-grow bg-black/60 border border-white/10 rounded-xl flex flex-col items-center justify-center hover:bg-black/80 transition-colors cursor-pointer group shadow-[0_0_20px_rgba(0,0,0,0.5)]" style="text-decoration: none;">
                                        <span class="text-6xl mb-4 group-hover:scale-110 transition-transform">▶️</span>
                                        <span class="text-gray-400 text-lg font-racing uppercase tracking-widest text-center">Ver Video en Enlace</span>
                                    </a>
                                @endif
                            @else
                                <div class="w-full h-full min-h-[300px] flex-grow bg-black/60 border border-white/10 rounded-xl flex flex-col items-center justify-center hover:bg-black/80 transition-colors cursor-pointer group shadow-[0_0_20px_rgba(0,0,0,0.5)]">
                                    <span class="text-6xl mb-4 group-hover:scale-110 transition-transform">▶️</span>
                                    <span class="text-gray-400 text-lg font-racing uppercase tracking-widest text-center">Video de la Carrera</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Biografía & Secciones Dinámicas (Grid Híbrido) -->
    <section id="biografia" class="py-20 px-6 relative bg-brand-black">
        <div class="max-w-7xl mx-auto space-y-12">
            
            @if($biography)
            <!-- Biografía (Diseño Premium) -->
            <div class="relative w-full rounded-3xl overflow-hidden shadow-[0_0_50px_rgba(230,32,32,0.1)] group">
                <!-- Capa de Fondo Dinámica -->
                <div class="absolute inset-0 bg-brand-dark"></div>
                <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-brand-red/20 via-transparent to-transparent opacity-80"></div>
                
                <div class="flex flex-col lg:flex-row relative z-10">
                    <!-- Columna de Imagen -->
                    <div class="w-full lg:w-1/2 relative min-h-[500px] lg:min-h-[650px] overflow-hidden lg:clip-path-bio">
                        @if($biography->image_path)
                            <div class="absolute inset-0 bg-brand-red/20 mix-blend-overlay z-10 transition-all duration-700 group-hover:bg-transparent"></div>
                            <img src="{{ asset('storage/' . $biography->image_path) }}" alt="{{ $biography->title }}" class="absolute inset-0 w-full h-full object-cover object-top filter grayscale group-hover:grayscale-0 transform group-hover:scale-105 transition-all duration-700">
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-gray-900 to-black flex items-center justify-center">
                                <span class="text-brand-gray font-light font-racing tracking-widest uppercase">Imagen del Piloto</span>
                            </div>
                        @endif
                        <!-- Elemento decorativo sobre la imagen -->
                        <div class="absolute bottom-10 left-10 z-20 pointer-events-none">
                            <div class="font-racing text-[10rem] leading-none text-white/30 select-none drop-shadow-2xl italic">88</div>
                        </div>
                    </div>
                    
                    <!-- Columna de Texto -->
                    <div class="w-full lg:w-1/2 p-10 md:p-16 lg:p-20 flex flex-col justify-center relative">
                        <!-- Línea conectora decorativa -->
                        <div class="hidden lg:block absolute -left-8 top-1/2 transform -translate-y-1/2 w-16 h-[3px] bg-brand-red z-20 shadow-[0_0_15px_rgba(230,32,32,0.6)]"></div>
                        
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-1 bg-brand-red"></div>
                            <h2 class="text-brand-red font-racing text-2xl uppercase tracking-widest drop-shadow-md">{{ $biography->title }}</h2>
                        </div>
                        
                        <h3 class="text-5xl md:text-7xl font-racing mb-8 leading-none uppercase italic text-white drop-shadow-lg">El Piloto <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-white to-gray-500">Detrás del Casco</span></h3>
                        
                        <div class="prose prose-invert prose-lg prose-p:text-gray-300 prose-p:leading-relaxed max-w-none font-light relative z-10">
                            {!! nl2br(e(str_ireplace('karting', 'fórmula 3', $biography->content))) !!}
                        </div>
                        
                        <!-- Footer de Biografía decorativo -->
                        <div class="mt-12 pt-8 border-t border-white/10 flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-2 h-2 rounded-full bg-brand-red animate-pulse"></div>
                                <span class="text-brand-gray text-sm uppercase tracking-widest font-racing"></span>
                            </div>
                            <img src="{{ asset('images/logos/letrero-conejo.png') }}" alt="Firma" class="h-10 opacity-60 filter brightness-200">
                        </div>
                    </div>
                </div>
            </div>
            <!-- Estilo para el recorte de la imagen en desktop -->
            <style>
                @media (min-width: 1024px) {
                    .lg\:clip-path-bio {
                        clip-path: polygon(0 0, 100% 0, 85% 100%, 0% 100%);
                    }
                }
            </style>

            <!-- Línea de Tiempo (Timeline Vertical) -->
            @if($biography->photo_1 || $biography->photo_2 || $biography->photo_3)
            <div class="relative mt-24 max-w-5xl mx-auto">
                <!-- Línea central brillante -->
                <div class="absolute left-1/2 transform -translate-x-1/2 top-0 bottom-0 w-1 bg-gradient-to-b from-brand-red via-red-900 to-transparent hidden md:block opacity-50 shadow-[0_0_15px_rgba(230,32,32,0.8)]"></div>
                <div class="absolute left-6 top-0 bottom-0 w-1 bg-gradient-to-b from-brand-red via-red-900 to-transparent md:hidden opacity-50"></div>

                @php
                    $defaultTexts = [
                        1 => 'Inicia su carrera profesonal a los 9 años quedando campeón de la zona norte del país.',
                        2 => 'Viajando desde Torreón a toda la República Mexicana para poder practicar y competir en nacionales, ya que donde vive no hay ninguna pista.',
                        3 => 'A los 15 años se va a vivir solo a España para continuar con su carrera deportiva enfrentándose a nuevos retos tanto dentro como fuera de la pista.'
                    ];
                @endphp
                @for($i = 1; $i <= 3; $i++)
                    @if($biography->{'photo_'.$i} || true)
                    <div class="relative flex items-center justify-between md:justify-normal md:even:flex-row-reverse group w-full mb-16 md:mb-24 fade-timeline-item opacity-0 translate-y-12 transition-all duration-1000 ease-out">
                        <!-- Punto central (Timeline node) -->
                        <div class="absolute left-6 md:left-1/2 transform -translate-x-1/2 w-6 h-6 bg-brand-black border-4 border-brand-red rounded-full z-20 group-hover:bg-brand-red transition-colors duration-300 shadow-[0_0_15px_rgba(230,32,32,0.8)]"></div>
                        
                        <!-- Contenido (Foto) -->
                        <div class="w-full md:w-5/12 pl-16 md:pl-0">
                            <div class="relative rounded-2xl overflow-hidden border border-white/10 shadow-2xl group-hover:shadow-[0_0_30px_rgba(230,32,32,0.2)] transition-all duration-500 transform group-hover:-translate-y-2 bg-black/40 flex items-center justify-center min-h-[16rem] md:min-h-[20rem]">
                                <div class="absolute inset-0 bg-brand-red/20 mix-blend-overlay group-hover:opacity-0 transition-opacity duration-500 z-10"></div>
                                @if($biography->{'photo_'.$i})
                                    <img src="{{ asset('storage/' . $biography->{'photo_'.$i}) }}" alt="Momento {{ $i }}" class="w-full h-64 md:h-80 object-contain object-center grayscale group-hover:grayscale-0 transition-all duration-700 p-2 relative z-20">
                                @else
                                    <div class="text-center relative z-20 opacity-50 p-4">
                                        <span class="text-5xl block mb-3">📸</span>
                                        <span class="text-gray-400 font-racing uppercase tracking-widest text-sm block">
                                            @if($i == 2) (Poner foto en Karts) @elseif($i == 3) (Poner foto F3/F4) @else Espacio para foto @endif
                                        </span>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Texto (Aparece debajo en móvil, o al lado en desktop) -->
                            <div class="mt-6 md:hidden text-gray-300 font-light text-lg">
                                {{ $biography->{'desc_'.$i} ?: $defaultTexts[$i] }}
                            </div>
                        </div>

                        <!-- Espaciador central (solo desktop) -->
                        <div class="hidden md:block w-2/12"></div>

                        <!-- Contenido (Texto - solo desktop) -->
                        <div class="hidden md:flex w-5/12 items-center">
                            <div class="bg-white/5 backdrop-blur-md border border-white/10 p-8 rounded-2xl w-full shadow-xl relative overflow-hidden group-hover:bg-white/10 transition-colors duration-500">
                                <div class="absolute top-0 left-0 w-1 h-full bg-brand-red"></div>
                                <h4 class="text-brand-red font-racing text-xl uppercase tracking-widest mb-3">Momento Clave</h4>
                                <p class="text-gray-300 font-light text-xl leading-relaxed">
                                    {{ $biography->{'desc_'.$i} ?: $defaultTexts[$i] }}
                                </p>
                            </div>
                        </div>
                    </div>
                    @endif
                @endfor
            </div>
            @endif
            @endif

            <!-- Grid de Secciones Dinámicas -->
            @if($sections->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 pt-10">
                @foreach($sections as $index => $section)
                    @php
                        $isPremium = str_contains(strtolower($section->title), 'inedit') || str_contains(strtolower($section->title), 'inédit');
                        $hasAccess = auth()->check() && auth()->user()->hasActiveSubscription();
                    @endphp

                    @if($isPremium && !$hasAccess)
                        @continue
                    @endif
                    <div class="bg-brand-dark border border-white/5 rounded-2xl overflow-hidden flex flex-col hover:border-white/10 transition-colors group">
                        @if($section->image_path)
                            <div class="w-full h-64 relative overflow-hidden">
                                <img src="{{ asset('storage/' . $section->image_path) }}" alt="{{ $section->title }}" class="w-full h-full object-cover transform group-hover:scale-105 transition-transform duration-700">
                            </div>
                        @endif
                        <div class="p-8 flex-grow flex flex-col">
                            <h2 class="text-3xl font-racing uppercase tracking-widest text-white mb-4 italic">{{ $section->title }}</h2>
                            <div class="prose prose-invert prose-p:text-gray-400 prose-sm flex-grow">
                                {!! nl2br(e($section->body)) !!}
                            </div>
                        </div>
                        <div class="h-1 w-0 bg-brand-red group-hover:w-full transition-all duration-500"></div>
                    </div>
                @endforeach
            </div>
            @endif
        </div>
    </section>

    @if(isset($merches) && $merches->count() > 0)
    <!-- Sección de Merch (Minimalista Cristal) -->
    <section id="merch" class="py-24 px-6 bg-brand-black relative z-20">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-1 border border-white/20 text-white/60 text-sm font-bold uppercase tracking-widest rounded-full mb-4 backdrop-blur-md">Tienda Oficial</div>
                <h2 class="text-5xl md:text-7xl font-racing tracking-wide text-white mb-4 uppercase italic">Conejo <span class="text-brand-red">Merch</span></h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto font-light">Vístete con los colores del equipo y apoya a Cristian en cada carrera.</p>
            </div>
            
            <div class="flex flex-wrap justify-center gap-8">
                @foreach($merches as $merch)
                <!-- Tarjeta de Merch Minimalista -->
                <div class="bg-white/5 border border-white/10 backdrop-blur-md rounded-2xl overflow-hidden flex flex-col group transition-all duration-500 hover:bg-white/10 hover:-translate-y-2 hover:shadow-[0_20px_40px_rgba(230,32,32,0.1)] cursor-pointer w-full max-w-sm" onclick="openMerchModal({{ $merch->id }}, '{{ addslashes($merch->title) }}', '{{ $merch->price }}', '{{ $merch->image_path ? asset('storage/' . $merch->image_path) : '' }}')">
                    <div class="relative h-72 w-full overflow-hidden bg-black/20 flex items-center justify-center p-6">
                        @if($merch->image_path)
                            <img src="{{ asset('storage/' . $merch->image_path) }}" alt="{{ $merch->title }}" class="w-full h-full object-contain filter drop-shadow-xl group-hover:scale-110 transition-transform duration-700">
                        @else
                            <span class="text-gray-600 font-racing uppercase tracking-widest">Sin Imagen</span>
                        @endif
                        
                        <!-- Overlay de "Ver más" -->
                        <div class="absolute inset-0 bg-brand-red/10 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-center justify-center backdrop-blur-[2px]">
                            <span class="bg-brand-red text-white font-racing tracking-wider uppercase px-6 py-2 rounded-full transform translate-y-4 group-hover:translate-y-0 transition-all duration-300 shadow-xl">Lo quiero</span>
                        </div>
                    </div>
                    <div class="p-6 text-center">
                        <h3 class="text-xl font-racing text-white uppercase tracking-wider mb-2">{{ $merch->title }}</h3>
                        <div class="text-brand-red font-bold text-lg">MXN ${{ number_format($merch->price, 2) }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Modal de Compra de Merch -->
    <div id="merch-modal" class="fixed inset-0 hidden items-center justify-center opacity-0 transition-opacity duration-300 backdrop-blur-sm bg-black/80 z-[9999] px-4">
        <div class="bg-brand-dark border border-white/10 rounded-2xl w-full max-w-lg transform scale-95 transition-transform duration-300 shadow-[0_0_50px_rgba(0,0,0,0.5)] relative overflow-hidden flex flex-col">
            <!-- Header decorativo -->
            <div class="h-2 w-full bg-gradient-to-r from-brand-red to-red-900"></div>
            
            <button onclick="closeMerchModal()" class="absolute top-4 right-4 text-gray-400 hover:text-white bg-black/50 hover:bg-brand-red rounded-full w-8 h-8 flex items-center justify-center transition-all z-20">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            
            <div class="p-8 text-center relative z-10 flex flex-col items-center">
                <div id="merch-modal-image-container" class="w-48 h-48 mb-6 flex items-center justify-center">
                    <img id="merch-modal-image" src="" alt="" class="w-full h-full object-contain drop-shadow-2xl">
                </div>
                
                <h3 id="merch-modal-title" class="text-3xl font-racing uppercase tracking-wider text-white mb-2">Producto</h3>
                <div id="merch-modal-price" class="text-2xl text-brand-red font-bold mb-8">MXN $0.00</div>
                
                <form id="merch-checkout-form" method="POST" action="" class="w-full">
                    @csrf
                    <button type="submit" class="w-full py-4 bg-[#009ee3] hover:bg-[#008acc] text-white font-racing uppercase tracking-widest rounded-xl transition-all shadow-[0_0_15px_rgba(0,158,227,0.4)] mb-4 flex items-center justify-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 14.5v-9l6 4.5-6 4.5z"/></svg>
                        Comprar con Mercado Pago
                    </button>
                </form>
                
                <button onclick="closeMerchModal()" class="w-full py-3 bg-white/5 hover:bg-white/10 text-white font-racing uppercase tracking-widest rounded-xl transition-all border border-white/5 text-sm">Volver</button>
            </div>
        </div>
    </div>
    @endif

    <!-- Opciones de Suscripción (Tarjetas Fusión) -->
    <section id="suscripciones" class="py-24 px-6 bg-brand-black relative">
        <div class="absolute inset-0 opacity-30 bg-[radial-gradient(circle_at_bottom_center,_var(--tw-gradient-stops))] from-brand-red/20 via-transparent to-transparent"></div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-1 border border-white/10 text-brand-gray text-sm font-bold uppercase tracking-widest rounded-full mb-4">Membresías</div>
                <h2 class="text-5xl md:text-7xl font-racing tracking-wide text-white mb-4 uppercase italic">Conejo <span class="text-brand-red">Club</span></h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto font-light">Sé parte de esta historia. ¡Vamos juntos a la Fórmula 1!</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-6xl mx-auto">
                <!-- Club Oro -->
                <div class="bg-brand-dark border border-yellow-500/50 flex flex-col shadow-xl transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_40px_rgba(234,179,8,0.15)] rounded-2xl overflow-hidden relative group">
                    <div class="p-8 pb-0">
                        <h4 class="text-2xl font-racing uppercase text-yellow-500 mb-1">Club Oro</h4>
                        <div class="font-racing text-5xl text-white mb-2">MXN {{ number_format($settings['club_oro_price']->value ?? 188) }}<span class="text-xl text-gray-600 font-sans normal-case ml-2">/ mes</span></div>
                    </div>
                    <div class="p-8 flex flex-col flex-grow">
                        <p class="text-sm text-gray-400 mb-6 flex-grow font-light">{!! nl2br(e($settings['club_oro_desc']->value ?? 'Quiero que formes parte real de este camino y que te conviertas en parte del equipo.

Tendrás acceso a noticias, beneficios y contenido exclusivo, pero sobre todo, serás parte de este gran proyecto.

Únete a Conejo Club. Sé parte de esta historia. ¡Vamos juntos a la Fórmula 1!')) !!}</p>
                        
                        <ul class="space-y-4 mb-8 text-sm text-gray-300">
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-yellow-500 mt-1.5 flex-shrink-0"></div>
                                + Video de bienvenida
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-yellow-500 mt-1.5 flex-shrink-0"></div>
                                + Credencial con # socio (PDF)
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-yellow-500 mt-1.5 flex-shrink-0"></div>
                                + Diploma digital de miembro oficial
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-yellow-500 mt-1.5 flex-shrink-0"></div>
                                + Contenido exclusivo fotos, videos y noticias.
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-yellow-500 mt-1.5 flex-shrink-0"></div>
                                + Mandarme mensajes directos
                            </li>
                        </ul>
                        
                        <a href="{{ route('subscribe', ['plan' => 'oro']) }}" class="block text-center w-full bg-white/5 border border-yellow-500/50 text-yellow-500 font-racing text-xl uppercase py-3 transition-colors hover:bg-yellow-500 hover:text-black rounded-xl">Unirse a Oro</a>
                    </div>
                </div>

                <!-- Club Titanio (Popular) -->
                <div class="bg-brand-dark border border-gray-400 flex flex-col shadow-[0_0_30px_rgba(156,163,175,0.15)] transition-all duration-300 hover:-translate-y-4 hover:shadow-[0_10px_50px_rgba(156,163,175,0.25)] rounded-2xl overflow-hidden relative md:-mt-4 md:mb-4 group">
                    <div class="absolute top-0 right-0 bg-gray-200 text-brand-black text-xs font-bold px-4 py-1 rounded-bl-lg uppercase tracking-widest z-10">Más Popular</div>
                    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-br from-gray-500/20 to-transparent"></div>
                    
                    <div class="p-8 pb-0 relative z-10">
                        <h4 class="text-2xl font-racing uppercase text-gray-300 mb-1">Club Titanio</h4>
                        <div class="font-racing text-5xl text-white mb-2">MXN {{ number_format($settings['club_titanio_price']->value ?? 788) }}<span class="text-xl text-gray-500 font-sans normal-case ml-2">/ mes</span></div>
                    </div>
                    <div class="p-8 flex flex-col flex-grow relative z-10">
                        <p class="text-sm text-gray-400 mb-6 flex-grow font-light">{!! nl2br(e($settings['club_titanio_desc']->value ?? 'Quiero que formes parte real de este camino y que te conviertas en parte del equipo.

Tendrás acceso a noticias, beneficios y contenido exclusivo, pero sobre todo, serás parte de este gran proyecto.

Únete a Conejo Club. Sé parte de esta historia. ¡Vamos juntos a la Fórmula 1!')) !!}</p>
                        
                        <div class="mb-4 font-bold text-gray-300 text-sm italic">Incluye todo Club Oro + :</div>
                        <ul class="space-y-4 mb-8 text-sm text-gray-300">
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-gray-400 mt-1.5 flex-shrink-0"></div>
                                + Descuentos exclusivos en Conejo Merch
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-gray-400 mt-1.5 flex-shrink-0"></div>
                                + Invitación a evento exclusivo de socios (CDMX y Torreón)
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-gray-400 mt-1.5 flex-shrink-0"></div>
                                + ¡Video personalizado de cumpleaños!
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-gray-400 mt-1.5 flex-shrink-0"></div>
                                + Participación sorteo anual Conejo Merch firmada (entrega gratis en México)
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-gray-400 mt-1.5 flex-shrink-0"></div>
                                Un conejo kit de regalo al cumplir 1 año (entrega gratis en México).
                            </li>
                        </ul>
                        <a href="{{ route('subscribe', ['plan' => 'titanio']) }}" class="block text-center w-full bg-gray-300 text-brand-black font-racing text-xl uppercase py-3 transition-colors hover:bg-white rounded-xl shadow-[0_0_15px_rgba(156,163,175,0.4)]">Unirse a Titanio</a>
                    </div>
                </div>

                <!-- Club Elite -->
                <div class="bg-brand-dark border border-brand-red flex flex-col shadow-[0_0_30px_rgba(230,32,32,0.15)] transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_10px_40px_rgba(230,32,32,0.25)] rounded-2xl overflow-hidden relative group">
                    <div class="absolute top-0 left-0 w-full h-32 bg-gradient-to-br from-brand-red/20 to-transparent z-0"></div>
                    <div class="p-8 pb-0 relative z-10">
                        <h4 class="text-2xl font-racing uppercase text-white mb-1">Club Elite</h4>
                        <div class="font-racing text-5xl text-white mb-2">MXN {{ number_format($settings['club_elite_price']->value ?? 1880) }}<span class="text-xl text-gray-500 font-sans normal-case ml-2">/ mes</span></div>
                    </div>
                    <div class="p-8 flex flex-col flex-grow relative z-10">
                        <p class="text-sm text-gray-400 mb-6 flex-grow font-light">{!! nl2br(e($settings['club_elite_desc']->value ?? 'Quiero que formes parte real de este camino y que te conviertas en parte del equipo.

Tendrás acceso a noticias, beneficios y contenido exclusivo, pero sobre todo, serás parte de este gran proyecto. ¡TENDRÁS TU NOMBRE EN MI AUTO!

Únete a Conejo Club. Sé parte de esta historia. ¡Vamos juntos a la Fórmula 1!')) !!}</p>
                        
                        <div class="mb-4 font-bold text-brand-red text-sm italic">Incluye todo Club Oro y Club Titanio + :</div>
                        <ul class="space-y-4 mb-8 text-sm text-gray-300">
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-brand-red mt-1.5 flex-shrink-0"></div>
                                + ¡Tu nombre en mi auto!
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-brand-red mt-1.5 flex-shrink-0"></div>
                                + Vídeo de agradecimiento exclusivo
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-brand-red mt-1.5 flex-shrink-0"></div>
                                + Posibilidad de 1 videollamada conmigo
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-brand-red mt-1.5 flex-shrink-0"></div>
                                + Un conejo kit VIP de regalo entrega gratis en México al cumplir 1 año 
                            </li>
                            <li class="flex items-start gap-3">
                                <div class="w-1.5 h-1.5 rounded-full bg-brand-red mt-1.5 flex-shrink-0"></div>
                                + Reconocimiento en una historia en redes sociales (si tú lo deseas)
                            </li>
                        </ul>
                        
                        <a href="{{ route('subscribe', ['plan' => 'elite']) }}" class="block text-center w-full bg-brand-red text-white font-racing text-xl uppercase py-3 transition-colors hover:bg-red-700 rounded-xl shadow-[0_0_15px_rgba(230,32,32,0.4)]">Unirse a Elite</a>
                    </div>
                </div>
            </div>

            <!-- Suscripciones Adicionales (Diamante y Aliado) -->
            <div class="mt-8 max-w-7xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <!-- Club Diamante -->
                <div class="bg-brand-black border border-cyan-500/30 flex flex-col items-start shadow-2xl transition-all duration-300 hover:border-cyan-400 hover:-translate-y-2 rounded-2xl overflow-hidden relative group p-8 md:p-10">
                    <!-- Destello de fondo -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-cyan-500/10 rounded-full blur-[80px] opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
                    
                    <div class="relative z-10 flex-grow mb-8">
                        <div class="flex items-center gap-3 mb-2">
                            <h4 class="text-3xl font-racing uppercase text-cyan-400 tracking-wide">Aportación Única</h4>
                        </div>
                        <div class="font-racing text-2xl text-white mb-4">Aportación Única</div>
                        <p class="text-gray-400 text-sm font-light leading-relaxed mb-2">
                            {!! nl2br(e($settings['club_apex_desc']->value ?? '¿Quieres apoyar aún más al proyecto? Te dejamos la puerta abierta para que tú decidas el monto. ¡Cualquier aportación suma para llegar a lo más alto!')) !!}
                        </p>
                    </div>
                    
                    <div class="w-full relative z-10">
                        <form id="form-apex" action="{{ route('donate') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                            @csrf
                            <div class="relative flex-grow">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-cyan-400 font-bold">$</span>
                                <input type="number" name="amount" min="1880" placeholder="1880" required class="w-full bg-brand-dark border-2 border-cyan-500/30 text-white rounded-xl py-3 pl-10 pr-4 focus:border-cyan-400 focus:ring-0 outline-none transition-all font-sans">
                            </div>
                            <button type="submit" class="inline-flex items-center justify-center bg-cyan-500/10 border-2 border-cyan-500 text-cyan-400 font-racing text-xl uppercase py-3 px-8 transition-all hover:bg-cyan-500 hover:text-black rounded-xl group-hover:shadow-[0_0_20px_rgba(6,182,212,0.4)]">
                                Aportar
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Club Diamante Mensual -->
                <div class="bg-brand-black border border-purple-500/30 flex flex-col items-start shadow-2xl transition-all duration-300 hover:border-purple-400 hover:-translate-y-2 rounded-2xl overflow-hidden relative group p-8 md:p-10">
                    <!-- Destello de fondo -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-purple-500/10 rounded-full blur-[80px] opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
                    
                    <div class="relative z-10 flex-grow mb-8">
                        <div class="flex items-center gap-3 mb-2">
                            <h4 class="text-3xl font-racing uppercase text-purple-400 tracking-wide">Club Diamante</h4>
                        </div>
                        <div class="font-racing text-2xl text-white mb-4">Aportación Mensual Libre</div>
                        <p class="text-gray-400 text-sm font-light leading-relaxed mb-2">
                            {!! nl2br(e($settings['club_diamante_desc']->value ?? '¿Quieres apoyar de manera constante y a tu medida? Aporta la cantidad que desees mes con mes y sé el motor de este sueño. ¡Cualquier apoyo es clave!')) !!}
                        </p>
                        <div class="mb-4 font-bold text-purple-400 text-sm italic">+ Incluye todos los beneficios del Club Élite</div>
                    </div>
                    
                    <div class="w-full relative z-10">
                        <form action="{{ route('donate.recurring') }}" method="POST" class="flex flex-col sm:flex-row gap-3">
                            @csrf
                            <div class="relative flex-grow">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-purple-400 font-bold">$</span>
                                <input type="number" name="amount" min="1880" placeholder="1880" required class="w-full bg-brand-dark border-2 border-purple-500/30 text-white rounded-xl py-3 pl-10 pr-4 focus:border-purple-400 focus:ring-0 outline-none transition-all font-sans">
                            </div>
                            <button type="submit" class="inline-flex items-center justify-center bg-purple-500/10 border-2 border-purple-500 text-purple-400 font-racing text-xl uppercase py-3 px-8 transition-all hover:bg-purple-500 hover:text-black rounded-xl group-hover:shadow-[0_0_20px_rgba(168,85,247,0.4)]">
                                Suscribir
                            </button>
                        </form>
                    </div>
                </div>

                <!-- Aliado Estratégico -->
                <div class="bg-brand-black border border-white/10 flex flex-col items-start shadow-2xl transition-all duration-300 hover:border-brand-red/50 hover:-translate-y-2 rounded-2xl overflow-hidden relative group p-8 md:p-10">
                    <!-- Destello de fondo -->
                    <div class="absolute top-0 right-0 w-64 h-64 bg-brand-red/10 rounded-full blur-[80px] opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>
                    
                    <div class="relative z-10 flex-grow mb-8">
                        <div class="flex items-center gap-3 mb-2">
                            <h4 class="text-3xl font-racing uppercase text-white tracking-wide">Aliado Estratégico</h4>
                        </div>
                        <div class="font-racing text-2xl text-brand-red mb-4">Plan a tu medida</div>
                        <p class="text-gray-400 text-sm font-light leading-relaxed">
                            Si quieres ser colaborador o aliado estratégico, te armamos un plan de beneficios y presencia de marca totalmente personalizado para ti o tu empresa.
                        </p>
                    </div>
                    
                    <div class="w-full relative z-10">
                        <a href="#contacto" class="inline-flex items-center justify-center w-full bg-brand-red text-white font-racing text-xl uppercase py-4 px-8 transition-all hover:bg-red-700 rounded-xl group-hover:shadow-[0_0_25px_rgba(230,32,32,0.4)]">
                            Contáctanos
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3 transform group-hover:translate-x-2 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>

    @if(isset($partners) && $partners->count() > 0)
    <!-- Sección de Colaboradores (Diseño Premium) -->
    <section id="colaboradores" class="py-24 px-6 relative z-20 overflow-hidden bg-brand-black">
        <!-- Fondos y destellos -->
        <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-brand-red/10 via-brand-black to-brand-black opacity-60"></div>
        <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-brand-red/50 to-transparent"></div>
        <div class="absolute bottom-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>
        
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="text-center mb-16 relative">
                <!-- Líneas decorativas de velocidad -->
                <div class="hidden md:block absolute top-1/2 left-0 w-1/4 h-[1px] bg-gradient-to-r from-transparent to-brand-red/40 transform -translate-y-1/2"></div>
                <div class="hidden md:block absolute top-1/2 right-0 w-1/4 h-[1px] bg-gradient-to-l from-transparent to-brand-red/40 transform -translate-y-1/2"></div>
                
                <div class="inline-block px-6 py-2 border border-brand-red/30 bg-brand-red/5 text-brand-red text-sm font-bold uppercase tracking-widest rounded-full mb-6 shadow-[0_0_15px_rgba(230,32,32,0.1)]">Aliados Estratégicos</div>
                <h2 class="text-5xl md:text-7xl font-racing tracking-wide text-white mb-6 uppercase italic">Nuestros <span class="text-brand-red">Partners</span></h2>
                <p class="text-gray-400 text-lg md:text-xl max-w-2xl mx-auto font-light">Marcas e instituciones que hacen posible este sueño y aceleran junto a nosotros hacia la cima.</p>
            </div>
            
            @php
                $featuredPartners = $partners->where('is_featured', true)->values();
                $otherPartners = $partners->where('is_featured', false)->values();
            @endphp

            @if($featuredPartners->count() > 0)
                <style>
                    @keyframes float {
                        0% { transform: translateY(0px); }
                        50% { transform: translateY(-15px); }
                        100% { transform: translateY(0px); }
                    }
                    .animate-float {
                        animation: float 6s ease-in-out infinite;
                    }
                    .animate-float-delayed {
                        animation: float 6s ease-in-out infinite;
                        animation-delay: 2s;
                    }
                    /* Pausar al pasar el ratón */
                    .animate-float:hover, .animate-float-delayed:hover {
                        animation-play-state: paused;
                    }
                </style>
                <!-- Podio de Destacados -->
                <div class="mb-16 flex flex-col items-center">
                    <!-- Primer lugar (Centro arriba) -->
                    @if($featuredPartners->has(0))
                        <div class="animate-float w-full max-w-3xl bg-brand-dark/60 backdrop-blur-md border-2 border-brand-red/50 hover:border-brand-red hover:bg-white/10 rounded-2xl p-6 md:p-8 transition-all duration-500 hover:shadow-[0_20px_40px_rgba(230,32,32,0.3)] group relative overflow-hidden flex items-center justify-center min-h-[380px] md:min-h-[450px] mb-8 z-20">
                            <div class="absolute top-0 right-0 w-48 h-48 bg-brand-red/30 rounded-full blur-2xl opacity-50 group-hover:opacity-100 transition-opacity duration-500"></div>
                            <div class="absolute top-4 left-1/2 transform -translate-x-1/2">
                                <span class="text-brand-red text-sm font-bold uppercase tracking-widest bg-brand-red/10 px-4 py-1.5 rounded-full border border-brand-red/30">Premium Partner</span>
                            </div>
                            <div class="w-full transition-transform duration-500 group-hover:scale-105 relative z-10 flex justify-center mt-4">
                                @if($featuredPartners[0]->url)
                                    <a href="{{ $featuredPartners[0]->url }}" target="_blank" rel="noopener noreferrer" class="block w-full flex justify-center">
                                        <img src="{{ asset('storage/' . $featuredPartners[0]->logo_path) }}" alt="{{ $featuredPartners[0]->name }}" class="w-auto h-auto object-contain max-h-96 max-w-full drop-shadow-2xl">
                                    </a>
                                @else
                                    <img src="{{ asset('storage/' . $featuredPartners[0]->logo_path) }}" alt="{{ $featuredPartners[0]->name }}" class="w-auto h-auto object-contain max-h-96 max-w-full drop-shadow-2xl">
                                @endif
                            </div>
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0 z-20 pointer-events-none">
                                <span class="bg-brand-black border border-brand-red text-white text-xs font-racing tracking-widest px-5 py-2 rounded-full uppercase whitespace-nowrap shadow-lg">{{ $featuredPartners[0]->name }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Segundo y Tercer lugar (Costados abajo) -->
                    @if($featuredPartners->has(1) || $featuredPartners->has(2))
                        <div class="flex flex-col md:flex-row justify-center gap-6 md:gap-12 w-full max-w-4xl -mt-4 md:-mt-12 z-10">
                            @foreach([1, 2] as $index)
                                @if($featuredPartners->has($index))
                                    <div class="animate-float-delayed w-full md:w-1/2 bg-brand-dark/50 backdrop-blur-sm border border-brand-red/30 hover:border-brand-red/70 hover:bg-white/5 rounded-xl p-8 transition-all duration-500 hover:shadow-[0_15px_30px_rgba(230,32,32,0.2)] group relative overflow-hidden flex items-center justify-center min-h-[200px]">
                                        <div class="absolute top-0 right-0 w-24 h-24 bg-brand-red/20 rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                                        <div class="w-full transition-transform duration-500 group-hover:scale-110 relative z-10 flex justify-center">
                                            @if($featuredPartners[$index]->url)
                                                <a href="{{ $featuredPartners[$index]->url }}" target="_blank" rel="noopener noreferrer" class="block w-full flex justify-center">
                                                    <img src="{{ asset('storage/' . $featuredPartners[$index]->logo_path) }}" alt="{{ $featuredPartners[$index]->name }}" class="w-auto h-auto object-contain max-h-32 max-w-[85%] drop-shadow-lg">
                                                </a>
                                            @else
                                                <img src="{{ asset('storage/' . $featuredPartners[$index]->logo_path) }}" alt="{{ $featuredPartners[$index]->name }}" class="w-auto h-auto object-contain max-h-32 max-w-[85%] drop-shadow-lg">
                                            @endif
                                        </div>
                                        <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0 z-20 pointer-events-none">
                                            <span class="bg-brand-black border border-brand-red/50 text-white text-xs font-racing tracking-widest px-4 py-1.5 rounded-full uppercase whitespace-nowrap shadow-lg">{{ $featuredPartners[$index]->name }}</span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>
                
                @if($otherPartners->count() > 0)
                    <div class="w-full h-[1px] bg-gradient-to-r from-transparent via-white/10 to-transparent mb-12"></div>
                @endif
            @endif
            
            @if($otherPartners->count() > 0)
            <style>
                @keyframes marquee {
                    0% { transform: translateX(0); }
                    100% { transform: translateX(-50%); }
                }
                .animate-marquee {
                    animation: marquee 35s linear infinite;
                    display: flex;
                    width: max-content;
                }
                .animate-marquee:hover {
                    animation-play-state: paused;
                }
            </style>
            
            <!-- Carrusel Infinito -->
            <div class="overflow-hidden relative w-full max-w-[100vw] mx-auto py-4">
                @if(session('error'))
                    <div class="fixed top-20 left-1/2 transform -translate-x-1/2 z-[100] w-full max-w-lg bg-red-600/90 border border-red-500 text-white px-6 py-4 rounded-xl shadow-2xl backdrop-blur-md flex justify-between items-center" id="toast-error">
                        <span>{{ session('error') }}</span>
                        <button onclick="document.getElementById('toast-error').style.display='none'" class="text-white hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif
                @if(session('success'))
                    <div class="fixed top-20 left-1/2 transform -translate-x-1/2 z-[100] w-full max-w-lg bg-green-600/90 border border-green-500 text-white px-6 py-4 rounded-xl shadow-2xl backdrop-blur-md flex justify-between items-center" id="toast-success">
                        <span>{{ session('success') }}</span>
                        <button onclick="document.getElementById('toast-success').style.display='none'" class="text-white hover:text-gray-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif
                <!-- Sombras en los bordes para un efecto de desvanecimiento -->
                <div class="absolute left-0 top-0 w-16 md:w-32 h-full bg-gradient-to-r from-brand-black to-transparent z-10 pointer-events-none"></div>
                <div class="absolute right-0 top-0 w-16 md:w-32 h-full bg-gradient-to-l from-brand-black to-transparent z-10 pointer-events-none"></div>

                <div class="animate-marquee gap-6 md:gap-8 px-4">
                    @php
                        // Clonamos la lista 4 veces para asegurar que llene pantallas grandes y cicle sin cortes
                        $carouselPartners = array_merge(
                            $otherPartners->all(), 
                            $otherPartners->all(), 
                            $otherPartners->all(), 
                            $otherPartners->all()
                        );
                    @endphp
                    @foreach($carouselPartners as $partner)
                        <div class="w-56 md:w-72 flex-shrink-0 bg-brand-dark/40 backdrop-blur-sm border border-white/5 hover:border-brand-red/40 hover:bg-white/5 rounded-xl p-6 md:p-8 transition-all duration-500 hover:-translate-y-2 hover:shadow-[0_15px_30px_rgba(230,32,32,0.15)] group relative overflow-hidden flex items-center justify-center min-h-[160px] md:min-h-[180px]">
                            <!-- Destello de esquina -->
                            <div class="absolute top-0 right-0 w-20 h-20 bg-brand-red/20 rounded-full blur-xl opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                            
                            <div class="w-full transition-transform duration-500 group-hover:scale-110 group-hover:-translate-y-2 filter grayscale group-hover:grayscale-0 relative z-10 flex justify-center">
                                @if($partner->url)
                                    <a href="{{ $partner->url }}" target="_blank" rel="noopener noreferrer" class="block w-full flex justify-center">
                                        <img src="{{ asset('storage/' . $partner->logo_path) }}" alt="{{ $partner->name }}" class="w-auto h-auto object-contain max-h-24 md:max-h-28 max-w-[85%] drop-shadow-lg">
                                    </a>
                                @else
                                    <img src="{{ asset('storage/' . $partner->logo_path) }}" alt="{{ $partner->name }}" class="w-auto h-auto object-contain max-h-24 md:max-h-28 max-w-[85%] drop-shadow-lg">
                                @endif
                            </div>
                            
                            <!-- Nombre en hover -->
                            <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 opacity-0 group-hover:opacity-100 transition-all duration-300 translate-y-2 group-hover:translate-y-0 z-20 pointer-events-none">
                                <span class="bg-brand-black border border-brand-red/50 text-white text-[10px] md:text-xs font-racing tracking-widest px-3 md:px-4 py-1 md:py-1.5 rounded-full uppercase whitespace-nowrap shadow-lg">{{ $partner->name }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>
    @endif


    <!-- Sección de Contacto -->
    <section id="contacto" class="py-24 px-6 relative z-20 overflow-hidden bg-brand-dark">
        <!-- Elementos decorativos de fondo -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-brand-red rounded-full blur-[120px] opacity-10"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-white rounded-full blur-[100px] opacity-5"></div>
        <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-white/10 to-transparent"></div>

        <div class="max-w-4xl mx-auto relative z-10">
            <div class="text-center mb-16">
                <div class="inline-block px-4 py-1 border border-white/20 text-white/60 text-sm font-bold uppercase tracking-widest rounded-full mb-4 backdrop-blur-md">Ponte en Contacto</div>
                <h2 class="text-5xl md:text-7xl font-racing tracking-wide text-white mb-4 uppercase italic">Hablemos de <span class="text-brand-red">Negocios</span></h2>
                <p class="text-gray-400 text-lg max-w-2xl mx-auto font-light">¿Interesado en colaborar con el equipo? Déjanos un mensaje y nos pondremos en contacto contigo lo antes posible.</p>
            </div>

            @if(session('contact_success'))
                <div class="bg-green-500/10 border border-green-500/30 text-green-400 p-6 rounded-2xl text-center mb-8 font-light text-lg flex flex-col items-center animate-fade-in-up">
                    <svg class="w-12 h-12 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('contact_success') }}
                </div>
            @endif

            <div class="bg-white/5 border border-white/10 backdrop-blur-xl rounded-3xl p-8 md:p-12 shadow-2xl relative overflow-hidden group">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-red via-red-900 to-transparent"></div>
                
                <form action="{{ route('contacto.store') }}" method="POST" class="space-y-6">
                    @csrf
                    
                    <!-- Honeypot oculto para bots -->
                    <div style="display:none;">
                        <label for="website_url">Deja este campo vacío si eres humano</label>
                        <input type="text" id="website_url" name="website_url" tabindex="-1" autocomplete="off">
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div class="space-y-2">
                            <label for="name" class="text-white/80 font-racing uppercase tracking-wider text-sm">Tu Nombre Completo *</label>
                            <input type="text" id="name" name="name" required class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-4 text-white placeholder-white/30 focus:outline-none focus:border-brand-red focus:ring-1 focus:ring-brand-red transition-all duration-300" placeholder="Ej. Juan Pérez">
                            @error('name') <span class="text-brand-red text-xs">{{ $message }}</span> @enderror
                        </div>

                        <!-- Email -->
                        <div class="space-y-2">
                            <label for="email" class="text-white/80 font-racing uppercase tracking-wider text-sm">Correo Electrónico *</label>
                            <input type="email" id="email" name="email" required class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-4 text-white placeholder-white/30 focus:outline-none focus:border-brand-red focus:ring-1 focus:ring-brand-red transition-all duration-300" placeholder="ejemplo@correo.com">
                            @error('email') <span class="text-brand-red text-xs">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Teléfono -->
                    <div class="space-y-2">
                        <label for="phone" class="text-white/80 font-racing uppercase tracking-wider text-sm">Teléfono (Opcional)</label>
                        <input type="tel" id="phone" name="phone" class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-4 text-white placeholder-white/30 focus:outline-none focus:border-brand-red focus:ring-1 focus:ring-brand-red transition-all duration-300" placeholder="Ej. +52 55 1234 5678">
                        @error('phone') <span class="text-brand-red text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Mensaje -->
                    <div class="space-y-2">
                        <label for="message" class="text-white/80 font-racing uppercase tracking-wider text-sm">Tu Mensaje *</label>
                        <textarea id="message" name="message" rows="5" required class="w-full bg-black/40 border border-white/10 rounded-xl px-5 py-4 text-white placeholder-white/30 focus:outline-none focus:border-brand-red focus:ring-1 focus:ring-brand-red transition-all duration-300 resize-y" placeholder="Cuéntanos en qué te gustaría colaborar..."></textarea>
                        @error('message') <span class="text-brand-red text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Captcha Matemático Simple -->
                    <div class="space-y-2 pb-2">
                        <label for="captcha" class="text-white/80 font-racing uppercase tracking-wider text-sm">Seguridad: ¿Cuánto es 5 + 3? *</label>
                        <input type="text" id="captcha" name="captcha" required class="w-full md:w-1/2 bg-black/40 border border-white/10 rounded-xl px-5 py-3 text-white placeholder-white/30 focus:outline-none focus:border-brand-red focus:ring-1 focus:ring-brand-red transition-all duration-300" placeholder="Escribe tu respuesta numérica (ej. 8)">
                        @error('captcha') <span class="text-brand-red text-xs">{{ $message }}</span> @enderror
                    </div>

                    <!-- Botón -->
                    <div class="pt-4 text-center">
                        <button type="submit" class="w-full md:w-auto inline-flex items-center justify-center bg-brand-red text-white font-racing tracking-widest uppercase text-xl px-12 py-5 rounded-full hover:bg-white hover:text-brand-red transition-all duration-300 group shadow-[0_0_20px_rgba(230,32,32,0.4)] hover:shadow-[0_0_30px_rgba(255,255,255,0.6)]">
                            <span>Enviar Mensaje</span>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 ml-3 transform group-hover:translate-x-2 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-brand-black border-t border-white/5 py-12 flex flex-col items-center justify-center gap-6 relative z-20">
        <a href="#" onclick="openSocialModal(event)" class="transition-transform hover:scale-105">
            <img src="{{ asset('images/logos/redes-blanco.png') }}" alt="Redes Sociales" class="h-8 md:h-10 w-auto object-contain opacity-70 hover:opacity-100 transition-opacity cursor-pointer">
        </a>
        <div class="flex flex-wrap justify-center gap-4 md:gap-8 text-sm font-light text-gray-500">
            <a href="{{ route('legal.privacidad') }}" class="hover:text-white transition-colors">Aviso de Privacidad</a>
            <a href="{{ route('legal.terminos') }}" class="hover:text-white transition-colors">Términos y Condiciones</a>
        </div>
        <p class="text-brand-gray font-light text-sm text-center px-4">&copy; {{ date('Y') }} Carreras Conejos AC. Todos los derechos reservados.</p>
    </footer>

    <!-- Botón Flotante WhatsApp -->
    <a href="https://wa.me/{{ $settings['whatsapp_number']->value ?? '5211234567890' }}?text={{ urlencode($settings['whatsapp_message']->value ?? 'Hola Cristian') }}" target="_blank" rel="noopener noreferrer" class="fixed bottom-6 right-6 bg-green-500 hover:bg-green-600 text-white p-4 rounded-full shadow-[0_0_20px_rgba(34,197,94,0.4)] hover:shadow-[0_0_30px_rgba(34,197,94,0.6)] hover:-translate-y-1 transition-all duration-300 z-50 flex items-center justify-center group">
        <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 0 0-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 0 1-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 0 1-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 0 1 2.893 6.994c-.003 5.45-4.437 9.884-9.885 9.885m8.413-18.297A11.815 11.815 0 0 0 12.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 0 0 5.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 0 0-3.48-8.413z"/>
        </svg>
        <span class="absolute right-14 bg-black text-white text-xs px-3 py-1 rounded shadow-lg opacity-0 group-hover:opacity-100 transition-opacity whitespace-nowrap">Hablar con el Equipo</span>
    </a>

    <!-- Modal Redes Sociales -->
    <div id="social-modal" class="fixed inset-0 hidden items-center justify-center opacity-0 transition-opacity duration-300 backdrop-blur-sm bg-black/60" style="z-index: 9999;">
        <div class="bg-brand-dark border border-brand-red rounded-xl p-8 w-full mx-4 transform scale-95 transition-transform duration-300 shadow-[0_0_40px_rgba(230,32,32,0.15)] relative" style="max-width: 400px;">
            <button onclick="closeSocialModal()" class="absolute top-4 right-4 text-brand-gray hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <h3 class="text-3xl font-racing text-center mb-6 italic text-white uppercase tracking-widest">Sigue a <span class="text-brand-red">Cristian</span></h3>
            
            <div class="space-y-4">
                <a href="{{ $settings['social_instagram']->value ?? '#' }}" target="_blank" class="flex items-center gap-4 bg-white/5 p-4 rounded-lg hover:bg-white/10 transition-colors border border-white/5 hover:border-brand-red/50 group">
                    <div class="bg-gradient-to-tr from-yellow-400 via-red-500 to-purple-500 w-10 h-10 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                    </div>
                    <span class="font-racing text-xl text-white tracking-widest group-hover:text-brand-red transition-colors">Instagram</span>
                </a>
                
                <a href="{{ $settings['social_facebook']->value ?? '#' }}" target="_blank" class="flex items-center gap-4 bg-white/5 p-4 rounded-lg hover:bg-white/10 transition-colors border border-white/5 hover:border-brand-red/50 group">
                    <div class="bg-blue-600 w-10 h-10 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                    </div>
                    <span class="font-racing text-xl text-white tracking-widest group-hover:text-brand-red transition-colors">Facebook</span>
                </a>
                
                <a href="{{ $settings['social_youtube']->value ?? '#' }}" target="_blank" class="flex items-center gap-4 bg-white/5 p-4 rounded-lg hover:bg-white/10 transition-colors border border-white/5 hover:border-brand-red/50 group">
                    <div class="bg-red-600 w-10 h-10 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                    </div>
                    <span class="font-racing text-xl text-white tracking-widest group-hover:text-brand-red transition-colors">YouTube</span>
                </a>
                
                <a href="{{ $settings['social_tiktok']->value ?? '#' }}" target="_blank" class="flex items-center gap-4 bg-white/5 p-4 rounded-lg hover:bg-white/10 transition-colors border border-white/5 hover:border-brand-red/50 group">
                    <div class="bg-black w-10 h-10 border border-white/20 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform">
                        <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.24-2.61.94-5.26 3.03-6.85 1.5-1.13 3.4-1.61 5.26-1.39.14 1.34.11 2.69.15 4.04-1.02-.27-2.12-.13-3.04.38-1.57.87-2.3 2.82-1.74 4.5.34 1.04 1.17 1.93 2.21 2.28 1.42.48 3.11.16 4.18-.89.84-.81 1.25-1.99 1.3-3.15.06-4.66.02-9.33.04-14.01z"/></svg>
                    </div>
                    <span class="font-racing text-xl text-white tracking-widest group-hover:text-brand-red transition-colors">TikTok</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Script de Animaciones y UX -->
    <script>
        // --- Modal de Merch ---
        function openMerchModal(id, title, price, imageSrc) {
            const modal = document.getElementById('merch-modal');
            const inner = modal.children[0];
            
            // Llenar datos
            document.getElementById('merch-modal-title').innerText = title;
            document.getElementById('merch-modal-price').innerText = 'MXN $' + parseFloat(price).toLocaleString('en-US', {minimumFractionDigits: 2});
            
            // Actualizar acción del formulario
            document.getElementById('merch-checkout-form').action = '/merch/' + id + '/checkout';
            
            const imgContainer = document.getElementById('merch-modal-image-container');
            const img = document.getElementById('merch-modal-image');
            
            if (imageSrc) {
                img.src = imageSrc;
                img.alt = title;
                imgContainer.style.display = 'flex';
            } else {
                imgContainer.style.display = 'none';
            }
            
            // Mostrar modal
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                inner.classList.remove('scale-95');
                inner.classList.add('scale-100');
            }, 10);
        }

        function closeMerchModal() {
            const modal = document.getElementById('merch-modal');
            const inner = modal.children[0];
            
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            inner.classList.remove('scale-100');
            inner.classList.add('scale-95');
            
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }

        // --- Modal de Redes Sociales ---
        function openSocialModal(e) {
            if(e) e.preventDefault();
            const modal = document.getElementById('social-modal');
            const inner = modal.children[0];
            
            // Primero mostramos el div (display: flex)
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            
            // Un pequeño retraso permite que la transición CSS de opacidad funcione
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modal.classList.add('opacity-100');
                inner.classList.remove('scale-95');
                inner.classList.add('scale-100');
            }, 10);
        }

        function closeSocialModal() {
            const modal = document.getElementById('social-modal');
            const inner = modal.children[0];
            
            // Primero iniciamos la transición de desaparición
            modal.classList.remove('opacity-100');
            modal.classList.add('opacity-0');
            inner.classList.remove('scale-100');
            inner.classList.add('scale-95');
            
            // Esperamos a que termine la transición (300ms) para ocultarlo del DOM
            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 300);
        }

        // Cerrar modal al clickear fuera
        document.getElementById('social-modal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeSocialModal();
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            // --- Animación Typewriter ---
            const textToType = "{{ str_ireplace('karting', 'fórmula 3', $settings['hero_typewriter']->value ?? 'Piloto profesional de Fórmula 3,Campeón Nacional 2023,Orgullo Mexicano') }}";
            const textElement = document.getElementById('typewriter-text');
            const buttonsElement = document.getElementById('hero-buttons');
            let typeIndex = 0;

            function typeWriter() {
                if (typeIndex < textToType.length) {
                    textElement.innerHTML += textToType.charAt(typeIndex);
                    typeIndex++;
                    setTimeout(typeWriter, 50); // Velocidad de tecleo
                } else {
                    // Cuando termina de escribir, mostrar los botones con un slide-in suave
                    buttonsElement.style.opacity = '1';
                    buttonsElement.style.transform = 'translateY(0)';
                }
            }
            
            // Iniciar la máquina de escribir después de medio segundo de cargar la página
            setTimeout(typeWriter, 500);

            // --- Barra de Progreso de Lectura ---
            const progressBar = document.getElementById('reading-progress');
            window.addEventListener('scroll', () => {
                const totalScroll = document.documentElement.scrollTop;
                const windowHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
                const scrollValue = `${totalScroll / windowHeight * 100}%`;
                progressBar.style.width = scrollValue;
                
                // Efecto de sombra sutil en la Navbar al hacer scroll
                const navbar = document.getElementById('navbar');
                if(totalScroll > 50) {
                    navbar.classList.add('shadow-lg', 'shadow-brand-red/10');
                } else {
                    navbar.classList.remove('shadow-lg', 'shadow-brand-red/10');
                }
            });

            // --- Animación de Estadísticas (Counter) ---
            const counters = document.querySelectorAll('.counter');
            const speed = 200; // Mientras más bajo, más rápido

            const animateCounters = () => {
                counters.forEach(counter => {
                    const updateCount = () => {
                        const target = +counter.getAttribute('data-target');
                        const count = +counter.innerText;
                        
                        // Calcular el incremento
                        const inc = target / speed;

                        if (count < target) {
                            counter.innerText = Math.ceil(count + inc);
                            setTimeout(updateCount, 20);
                        } else {
                            counter.innerText = target;
                        }
                    };
                    updateCount();
                });
            };

            // Intersection Observer para disparar la animación cuando el usuario hace scroll
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.5 // Se dispara cuando el 50% de la sección es visible
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateCounters();
                        observer.unobserve(entry.target); // Solo animar una vez
                    }
                });
            }, observerOptions);

            const statsContainer = document.getElementById('stats-container');
            if (statsContainer) {
                observer.observe(statsContainer);
            }

            // --- Animaciones al hacer Scroll (Reveal suave) ---
            // Seleccionamos elementos clave como secciones, tarjetas y componentes del grid
            const revealElements = document.querySelectorAll('section > div > h2, .bg-brand-dark, footer');
            
            // Les aplicamos las clases iniciales ocultas (Tailwind)
            revealElements.forEach(el => {
                el.classList.add('opacity-0', 'translate-y-10', 'transition-all', 'duration-1000', 'ease-out');
            });

            const revealObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        // Agregamos un ligero retraso escalonado para elementos que aparecen al mismo tiempo
                        setTimeout(() => {
                            entry.target.classList.remove('opacity-0', 'translate-y-10');
                            entry.target.classList.add('opacity-100', 'translate-y-0');
                        }, index * 100); 
                        
                        observer.unobserve(entry.target);
                    }
                });
            }, { root: null, rootMargin: '0px', threshold: 0.15 });

            revealElements.forEach(el => revealObserver.observe(el));

            // --- Animación del Timeline ---
            const timelineItems = document.querySelectorAll('.fade-timeline-item');
            
            const timelineObserver = new IntersectionObserver((entries, observer) => {
                entries.forEach((entry, index) => {
                    if (entry.isIntersecting) {
                        setTimeout(() => {
                            entry.target.classList.remove('opacity-0', 'translate-y-12');
                            entry.target.classList.add('opacity-100', 'translate-y-0');
                        }, index * 200); // Efecto escalonado más notorio para el timeline
                        
                        observer.unobserve(entry.target);
                    }
                });
            }, { root: null, rootMargin: '0px', threshold: 0.2 });

            timelineItems.forEach(el => timelineObserver.observe(el));
        });
    </script>

    <!-- Banner de Privacidad -->
    <div id="cookie-banner" class="fixed bottom-0 left-0 w-full bg-brand-dark/95 backdrop-blur-md border-t border-brand-red/50 text-white z-[9999] transform translate-y-full transition-transform duration-700 shadow-[0_-10px_40px_rgba(0,0,0,0.5)]">
        <div class="max-w-7xl mx-auto px-6 py-4 md:py-6 flex flex-col md:flex-row items-center justify-between gap-4">
            <div class="text-sm text-gray-300 font-light flex-1 text-center md:text-left">
                Al navegar en nuestro sitio web, aceptas nuestro 
                <a href="{{ route('legal.privacidad') }}" class="text-brand-red hover:text-white underline transition-colors">Aviso de Privacidad</a> y 
                <a href="{{ route('legal.terminos') }}" class="text-brand-red hover:text-white underline transition-colors">Términos y Condiciones</a>.
            </div>
            <div class="flex-shrink-0 w-full md:w-auto">
                <button id="accept-cookies" class="w-full md:w-auto bg-brand-red hover:bg-red-700 text-white px-8 py-2 rounded-lg font-racing uppercase tracking-widest text-lg transition-colors">
                    Aceptar
                </button>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cookieBanner = document.getElementById('cookie-banner');
            const acceptBtn = document.getElementById('accept-cookies');
            
            // Comprobar si el usuario ya aceptó (en localStorage)
            if (!localStorage.getItem('cookies_accepted')) {
                // Mostrar banner con un pequeño retraso
                setTimeout(() => {
                    cookieBanner.classList.remove('translate-y-full');
                }, 1000);
            }

            acceptBtn.addEventListener('click', function() {
                // Guardar consentimiento
                localStorage.setItem('cookies_accepted', 'true');
                // Ocultar banner
                cookieBanner.classList.add('translate-y-full');
            });

            // Autoplay de video cuando está visible (IntersectionObserver)
            const videoElement = document.getElementById('featured-video');
            const youtubeElement = document.getElementById('featured-youtube');
            
            if (videoElement || youtubeElement) {
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            if (videoElement) videoElement.play().catch(e => console.log('Autoplay prevent:', e));
                            if (youtubeElement) youtubeElement.contentWindow.postMessage('{"event":"command","func":"playVideo","args":""}', '*');
                        } else {
                            if (videoElement) videoElement.pause();
                            if (youtubeElement) youtubeElement.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
                        }
                    });
                }, { threshold: 0.5 }); // Se activa cuando el 50% del video es visible

                if (videoElement) observer.observe(videoElement);
                if (youtubeElement) observer.observe(youtubeElement);
            }
        });
    </script>
</body>
</html>
