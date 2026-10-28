@extends('admin.layout')

@section('title', 'Dashboard')

@section('content')
<header class="admin-header">
    <a href="/" class="brand">CANTÚ<span>88</span></a>
    
    <div class="user-menu">
        <a href="{{ route('dashboard') }}" style="color: var(--color-gray); text-decoration: none; font-size: 0.9rem; margin-right: 10px;">Vista Miembro</a>
        <span style="color: var(--color-gray); margin: 0 5px;">|</span>
        <a href="/" style="color: var(--color-gray); text-decoration: none; font-size: 0.9rem; margin: 0 10px;">Ver Web</a>
        <span style="color: var(--color-gray); margin: 0 5px;">|</span>
        <span style="margin-left: 10px;">Hola, {{ auth()->user()->name }}</span>
        <span style="color: var(--color-gray); margin: 0 10px;">|</span>
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit">Cerrar Sesión</button>
        </form>
    </div>
</header>

<div class="container">
    <div style="margin-bottom: 2rem;">
        <h1 style="font-size: 2rem; margin-bottom: 0.5rem;">Panel Principal</h1>
        <p style="color: var(--color-gray);">Bienvenido al centro de control de tu biografía y contenido premium.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        
        <div class="glass-panel" style="padding: 2rem;">
            <h2 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                <span style="color: var(--color-red); font-size: 1.5rem;">●</span> Biografía
            </h2>
            <p style="color: var(--color-gray); margin-bottom: 1.5rem;">Actualiza tu historia personal, estadísticas y logros como piloto.</p>
            <a href="{{ route('admin.biography.edit') }}" class="btn" style="text-decoration: none;">Editar Biografía</a>
        </div>

        <div class="glass-panel" style="padding: 2rem;">
            <h2 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                <span style="color: var(--color-red); font-size: 1.5rem;">★</span> Contenido Premium
            </h2>
            <p style="color: var(--color-gray); margin-bottom: 1.5rem;">Publica contenido exclusivo, fotos y noticias para tus suscriptores.</p>
            <a href="{{ route('admin.content.index') }}" class="btn" style="text-decoration: none;">Gestionar Contenido</a>
        </div>

        <div class="glass-panel" style="padding: 2rem;">
            <h2 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                <span style="color: var(--color-red); font-size: 1.5rem;">🛍</span> Merchandising
            </h2>
            <p style="color: var(--color-gray); margin-bottom: 1.5rem;">Sube y administra los artículos de tu tienda oficial de merch.</p>
            <a href="{{ route('admin.merch.index') }}" class="btn" style="text-decoration: none;">Gestionar Merch</a>
        </div>

        <div class="glass-panel" style="padding: 2rem;">
            <h2 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                <span style="color: var(--color-red); font-size: 1.5rem;">$</span> Suscriptores
            </h2>
            <p style="color: var(--color-gray); margin-bottom: 1.5rem;">Revisa quién te está apoyando a través de MercadoPago.</p>
            <button class="btn">Ver Suscriptores</button>
        </div>

        <div class="glass-panel" style="padding: 2rem;">
            <h2 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                <span style="color: var(--color-red); font-size: 1.5rem;">★</span> Aliados
            </h2>
            <p style="color: var(--color-gray); margin-bottom: 1.5rem;">Gestiona las empresas e instituciones que te apoyan.</p>
            <a href="{{ route('admin.partners.index') }}" class="btn" style="text-decoration: none;">Ver Aliados</a>
        </div>

        <div class="glass-panel" style="padding: 2rem;">
            <h2 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                <span style="color: var(--color-red); font-size: 1.5rem;">🏁</span> Carrera Destacada
            </h2>
            <p style="color: var(--color-gray); margin-bottom: 1.5rem;">Modifica el texto, la foto del podio y el video de la carrera principal.</p>
            <a href="{{ route('admin.featured-race.edit') }}" class="btn" style="text-decoration: none;">Editar Carrera</a>
        </div>

        <div class="glass-panel" style="padding: 2rem;">
            <h2 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                <span style="color: var(--color-red); font-size: 1.5rem;">⚙</span> Configuraciones
            </h2>
            <p style="color: var(--color-gray); margin-bottom: 1.5rem;">Modifica textos principales, estadísticas, y precios del club.</p>
            <a href="{{ route('admin.settings.index') }}" class="btn" style="text-decoration: none;">Editar Ajustes</a>
        </div>

        <div class="glass-panel" style="padding: 2rem; border-color: rgba(230, 32, 32, 0.4);">
            <h2 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                <span style="color: var(--color-red); font-size: 1.5rem;">✉</span> Mensajes
                @php
                    $unread = \App\Models\ContactMessage::where('is_read', false)->count();
                @endphp
                @if($unread > 0)
                    <span style="background: var(--color-red); color: white; border-radius: 50%; padding: 2px 8px; font-size: 0.8rem; margin-left: 5px;">{{ $unread }}</span>
                @endif
            </h2>
            <p style="color: var(--color-gray); margin-bottom: 1.5rem;">Lee y administra los correos y mensajes de tus colaboradores.</p>
            <a href="{{ route('admin.contacts.index') }}" class="btn" style="text-decoration: none; background: var(--color-white); color: var(--color-black);">Ver Bandeja</a>
        </div>
        <div class="glass-panel" style="padding: 2rem; border-color: rgba(230, 32, 32, 0.4);">
            <h2 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                <span style="color: var(--color-red); font-size: 1.5rem;">🎂</span> Cumpleaños
            </h2>
            <p style="color: var(--color-gray); margin-bottom: 1.5rem;">Consulta los próximos cumpleaños de los miembros de Conejo Club.</p>
            <a href="{{ route('admin.birthdays.index') }}" class="btn" style="text-decoration: none;">Ver Calendario</a>
        </div>


        <div class="glass-panel" style="padding: 2rem; border-color: rgba(230, 32, 32, 0.4);">
            <h2 style="margin-bottom: 1rem; display: flex; align-items: center; gap: 10px;">
                <span style="color: var(--color-red); font-size: 1.5rem;">🛠</span> Herramientas
            </h2>
            <p style="color: var(--color-gray); margin-bottom: 1.5rem;">Prueba que el sistema de envío de correos esté funcionando correctamente.</p>
            <form action="{{ route('admin.test.email') }}" method="POST">
                @csrf
                <button type="submit" class="btn" style="background: var(--color-red); color: white; cursor: pointer; width: 100%;">Enviar Correo de Prueba</button>
            </form>
        </div>

    </div>
</div>
@endsection
