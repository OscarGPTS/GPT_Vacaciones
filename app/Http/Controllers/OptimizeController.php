<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class OptimizeController extends Controller
{
    /**
     * Mostrar la vista de optimización
     */
    public function index()
    {
        // Solo usuarios con permiso 'ver modulo rrhh' pueden acceder
        if (!auth()->user()->can('ver modulo rrhh')) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return view('admin.optimize');
    }

    /**
     * Ejecutar un comando específico
     */
    public function executeCommand(Request $request)
    {
        // Solo usuarios con permiso 'ver modulo rrhh' pueden ejecutar
        if (!auth()->user()->can('ver modulo rrhh')) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        $command = $request->input('command');
        $allowedCommands = [
            'optimize' => 'optimize',
            'cache:clear' => 'cache:clear',
            'config:clear' => 'config:clear',
            'route:clear' => 'route:clear',
            'view:clear' => 'view:clear',
            'config:cache' => 'config:cache',
            'route:cache' => 'route:cache',
            'view:cache' => 'view:cache',
            'storage:link' => 'storage:link',
        ];

        if (!array_key_exists($command, $allowedCommands)) {
            return back()->with('error', '❌ Comando no permitido.');
        }

        try {
            Artisan::call($allowedCommands[$command]);
            $output = Artisan::output();
            
            $commandName = $this->getCommandName($command);
            
            return back()->with('success', "✅ Comando ejecutado: <strong>{$commandName}</strong><br><pre class='mb-0 mt-2'>{$output}</pre>");
        } catch (\Exception $e) {
            return back()->with('error', '❌ Error al ejecutar el comando: ' . $e->getMessage());
        }
    }

    /**
     * Ejecutar todos los comandos de optimización
     */
    public function optimizeAll()
    {
        // Solo usuarios con permiso 'ver modulo rrhh' pueden ejecutar
        if (!auth()->user()->can('ver modulo rrhh')) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        $results = [];
        $errors = [];

        $commands = [
            'cache:clear' => 'Limpiar Caché',
            'config:clear' => 'Limpiar Configuración',
            'route:clear' => 'Limpiar Rutas',
            'view:clear' => 'Limpiar Vistas',
            'config:cache' => 'Cachear Configuración',
            'route:cache' => 'Cachear Rutas',
            'view:cache' => 'Cachear Vistas',
            'optimize' => 'Optimizar Sistema',
        ];

        foreach ($commands as $cmd => $name) {
            try {
                Artisan::call($cmd);
                $results[] = "✅ {$name}: OK";
            } catch (\Exception $e) {
                $errors[] = "❌ {$name}: " . $e->getMessage();
            }
        }

        $message = '<strong>Optimización Completa</strong><br>';
        $message .= implode('<br>', $results);
        
        if (!empty($errors)) {
            $message .= '<br><br><strong class="text-danger">Errores:</strong><br>';
            $message .= implode('<br>', $errors);
        }

        return back()->with('success', $message);
    }

    /**
     * Obtener información del sistema
     */
    public function systemInfo()
    {
        // Solo usuarios con permiso 'ver modulo rrhh' pueden acceder
        if (!auth()->user()->can('ver modulo rrhh')) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        $info = [
            'Laravel Version' => app()->version(),
            'PHP Version' => PHP_VERSION,
            'Environment' => app()->environment(),
            'Debug Mode' => config('app.debug') ? 'Activado' : 'Desactivado',
            'URL' => config('app.url'),
            'Timezone' => config('app.timezone'),
            'Locale' => config('app.locale'),
            'Cache Driver' => config('cache.default'),
            'Session Driver' => config('session.driver'),
            'Queue Driver' => config('queue.default'),
        ];

        return response()->json($info);
    }

    /**
     * Obtener nombre descriptivo del comando
     */
    private function getCommandName($command)
    {
        $names = [
            'optimize' => 'Optimizar Sistema',
            'cache:clear' => 'Limpiar Caché',
            'config:clear' => 'Limpiar Configuración',
            'route:clear' => 'Limpiar Rutas',
            'view:clear' => 'Limpiar Vistas',
            'config:cache' => 'Cachear Configuración',
            'route:cache' => 'Cachear Rutas',
            'view:cache' => 'Cachear Vistas',
            'storage:link' => 'Enlazar Storage',
        ];

        return $names[$command] ?? $command;
    }
}
