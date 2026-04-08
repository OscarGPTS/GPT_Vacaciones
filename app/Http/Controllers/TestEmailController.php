<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestEmail;

class TestEmailController extends Controller
{
    /**
     * Mostrar el formulario de prueba de correo
     */
    public function index()
    {
        // Solo usuarios con permiso 'ver modulo rrhh' pueden acceder
        if (!auth()->user()->can('ver modulo rrhh')) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return view('admin.test-email');
    }

    /**
     * Enviar correo de prueba
     */
    public function send(Request $request)
    {
        // Solo usuarios con permiso 'ver modulo rrhh' pueden enviar
        if (!auth()->user()->can('ver modulo rrhh')) {
            abort(403, 'No tienes permiso para realizar esta acción.');
        }

        $request->validate([
            'email' => 'required|email',
        ], [
            'email.required' => 'El correo electrónico es obligatorio.',
            'email.email' => 'El correo electrónico debe ser una dirección válida.',
        ]);

        try {
            $senderName = auth()->user()->first_name . ' ' . auth()->user()->last_name;
            $senderEmail = auth()->user()->email;

            Mail::to($request->email)->send(new TestEmail($senderName, $senderEmail));

            return back()->with('success', '✅ Correo de prueba enviado exitosamente a: ' . $request->email);
        } catch (\Exception $e) {
            return back()->with('error', '❌ Error al enviar el correo: ' . $e->getMessage());
        }
    }
}
