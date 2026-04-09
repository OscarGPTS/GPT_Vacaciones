<?php

namespace App\Providers;

use Livewire\Livewire;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Opcodes\LogViewer\Facades\LogViewer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Forzar HTTPS cuando se usa túnel o en producción
        if (config('app.force_https', false) || request()->header('X-Forwarded-Proto') === 'https') {
            URL::forceScheme('https');
        }

        $project_title = '| RRHH';
        Route::resourceVerbs([
            'create' => 'crear',
            'edit' => 'editar'
        ]);

        // Livewire::setScriptRoute(function ($handle) {
        //     return Route::get('/vendor/livewire/livewire.js', $handle);
        // });
        View::share('title_page', $project_title);

        // Registrar View Composer para la sidebar
        View::composer('layouts.codebase.sidebar', \App\View\Composers\SidebarComposer::class);

        LogViewer::auth(function ($request) {
            return $request->user()
                && in_array($request->user()->email, [
                    'ahernandezm@gptservices.com',
                ]);
        });
    }
}
