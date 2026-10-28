<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\BiographyController;
use App\Http\Controllers\Admin\ContentController;
use App\Http\Controllers\Admin\PartnerController;
use App\Http\Controllers\Admin\BirthdayController;
use App\Http\Controllers\Admin\FeaturedRaceController;
use App\Http\Controllers\ProfileController;

use App\Models\Biography;
use App\Models\Content;
use App\Models\Partner;

// Vista Pública (Landing Page)
Route::get('/', function () {
    $biography = Biography::where('is_active', true)->first();
    $sections = \App\Models\Content::orderBy('sort_order', 'asc')->get();
    $partners = \App\Models\Partner::where('is_active', true)->orderBy('sort_order')->get();
    $settings = \App\Models\Setting::all()->keyBy('key');
    $merches = \App\Models\Merch::where('is_active', true)->orderBy('sort_order')->get();
    $featuredRace = \App\Models\FeaturedRace::first();
    return view('welcome', compact('biography', 'sections', 'partners', 'settings', 'merches', 'featuredRace'));
});

// Checkout de Merch (Mercado Pago)
Route::post('/merch/{merch}/checkout', [\App\Http\Controllers\MerchCheckoutController::class, 'checkout'])->name('merch.checkout');

// Rutas de Ayuda/Técnicas
Route::get('/crear-symlink', function () {
    try {
        \Illuminate\Support\Facades\Artisan::call('storage:link');
        return "¡Enlace simbólico creado con éxito! Ya deberían verse las imágenes.";
    } catch (\Exception $e) {
        return "Error al crear el enlace: " . $e->getMessage();
    }
});

// Rutas Legales
Route::view('/aviso-de-privacidad', 'legal.aviso-privacidad')->name('legal.privacidad');
Route::view('/terminos-y-condiciones', 'legal.terminos')->name('legal.terminos');

// Rutas de Administración
Route::prefix('admin')->name('admin.')->group(function () {
    // Autenticación
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login')->middleware('guest');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post')->middleware('guest');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

    // Panel de Control (Protegido)
    Route::middleware(['auth', 'admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Biografía
        Route::get('/biography', [BiographyController::class, 'edit'])->name('biography.edit');
        Route::post('/biography', [BiographyController::class, 'update'])->name('biography.update');

        // Carrera Destacada
        Route::get('/featured-race', [FeaturedRaceController::class, 'edit'])->name('featured-race.edit');
        Route::post('/featured-race', [FeaturedRaceController::class, 'update'])->name('featured-race.update');

        // Contenido (Noticias/Posts)
        Route::resource('/content', ContentController::class)->except(['show']);

        // Aliados / Socios
        Route::resource('/partners', PartnerController::class)->except(['show']);
        
        // Cumpleaños
        Route::get('/birthdays', [BirthdayController::class, 'index'])->name('birthdays.index');
        
        // Rutas de Configuración del Sistema
        Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('settings.update');

        // Rutas de Merch
        Route::resource('/merch', \App\Http\Controllers\Admin\MerchController::class)->except(['show']);

        // Rutas de Contacto
        Route::resource('/contacts', \App\Http\Controllers\Admin\ContactMessageController::class)->only(['index', 'show', 'destroy']);
        
        // Botón de Test de Email
        Route::post('/test-email', function () {
            try {
                \Illuminate\Support\Facades\Mail::to('contacto@conejocantu.com')->send(new \App\Mail\ThankYouMail([
                    'name' => 'Piloto de Pruebas',
                    'plan' => 'Membresía de Prueba',
                    'is_subscription' => true,
                ]));
                return back()->with('success', '¡Correo de prueba enviado con éxito a contacto@conejocantu.com!');
            } catch (\Exception $e) {
                return back()->with('error', 'Error al enviar: ' . $e->getMessage());
            }
        })->name('test.email');
    });
});

Route::post('/contacto', [\App\Http\Controllers\ContactController::class, 'store'])->name('contacto.store');

// --- BREEZE USER ROUTES ---

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Suscripciones
    Route::get('/subscribe/{plan}', [\App\Http\Controllers\SubscriptionController::class, 'subscribe'])->name('subscribe');
});

// Webhook de Mercado Pago
Route::post('/webhooks/mercadopago', [\App\Http\Controllers\WebhookController::class, 'handleWebhook'])->name('webhook.mp');

// Aportación a la medida (Pública)
Route::post('/donate', [\App\Http\Controllers\SubscriptionController::class, 'donate'])->name('donate');
Route::post('/donate/recurring', [\App\Http\Controllers\SubscriptionController::class, 'donateRecurring'])->name('donate.recurring');

require __DIR__.'/auth.php';
