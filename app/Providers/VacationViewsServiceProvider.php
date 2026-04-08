<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Event;
use Illuminate\Database\Events\MigrationsEnded;

class VacationViewsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Recrear vistas automáticamente después de ejecutar migraciones
        Event::listen(MigrationsEnded::class, function () {
            // Solo en entorno local/desarrollo para evitar fallos en producción
            if (app()->environment(['local', 'development'])) {
                try {
                    Artisan::call('vacation:recreate-views', ['--force' => true]);
                    echo "\n✅ Vistas cross-database recreadas automáticamente\n";
                } catch (\Exception $e) {
                    echo "\n⚠️  No se pudieron recrear vistas: " . $e->getMessage() . "\n";
                }
            }
        });
    }
}
