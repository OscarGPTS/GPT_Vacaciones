<?php

namespace App\Http\Controllers\Perfil;

use App\Http\Controllers\Controller;
use App\Models\UserSignature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FirmaController extends Controller
{
    /**
     * Guardar o actualizar la firma del usuario autenticado.
     * Recibe la imagen como base64 (data:image/png;base64,...).
     */
    public function store(Request $request)
    {
        $request->validate([
            'signature' => ['required', 'string'],
        ]);

        $data = $request->input('signature');

        // Validar que sea una imagen base64 PNG válida
        if (!preg_match('/^data:image\/png;base64,/', $data)) {
            return back()->with('firma_error', 'Formato de firma inválido. Usa el canvas para dibujar tu firma.');
        }

        $base64 = preg_replace('/^data:image\/png;base64,/', '', $data);
        $decoded = base64_decode($base64, true);

        if ($decoded === false || strlen($decoded) < 100) {
            return back()->with('firma_error', 'La firma está vacía o es inválida. Por favor dibuja tu firma antes de guardar.');
        }

        $user = Auth::user();
        $dir  = public_path('firmas/usuarios');

        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $filename = 'firma_' . $user->id . '.png';
        $fullPath = $dir . DIRECTORY_SEPARATOR . $filename;

        file_put_contents($fullPath, $decoded);

        $url = 'firmas/usuarios/' . $filename . '?v=' . time();

        UserSignature::updateOrCreate(
            ['user_id' => $user->id],
            ['signature_url' => 'firmas/usuarios/' . $filename]
        );

        return back()->with('firma_guardada', 'Firma registrada correctamente. Ya puedes crear solicitudes.');
    }

    /**
     * Eliminar la firma del usuario autenticado.
     */
    public function destroy()
    {
        $user = Auth::user();
        $sig  = UserSignature::forUser($user->id);

        if ($sig) {
            $fullPath = public_path($sig->signature_url);
            if (file_exists($fullPath)) {
                unlink($fullPath);
            }
            // Conservar el registro para no perder la aceptación de términos
            $sig->update(['signature_url' => null]);
        }

        return back()->with('firma_eliminada', 'Firma eliminada. Deberás registrar una nueva para poder crear solicitudes.');
    }
}
