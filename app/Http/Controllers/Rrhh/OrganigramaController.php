<?php

namespace App\Http\Controllers\Rrhh;

use App\Models\User;
use App\Models\Area;
use App\Models\Departamento;
use App\Http\Controllers\Controller;
use App\Models\Job;
use Illuminate\Http\Request;

class OrganigramaController extends Controller
{
    public function index()
    {   
        $departamentos = Departamento::orderBy('name')->get();
        return view('rrhh.organigrama.index', compact('departamentos'));
    }

    public function getEmployees(Request $request)
    {
        // Verificar si hay filtro de departamentos
        $departments = $request->query('departments');
        $convertImages = $request->query('convert_images', false);
        
        if ($departments) {
            // Convertir string a array
            $departmentIds = explode(',', $departments);
            
            // Obtener usuarios de los departamentos seleccionados
            $users = User::where('active', 1)
                ->whereHas('job', function($query) use ($departmentIds) {
                    $query->whereIn('depto_id', $departmentIds);
                })
                ->with('job')
                ->get();

            // También incluir los jefes de estos usuarios para mantener la jerarquía
            $bossIds = $users->pluck('boss_id')->filter()->unique();
            $bosses = User::whereIn('id', $bossIds)->where('active', 1)->with('job')->get();

            // Combinar ambos conjuntos y eliminar duplicados
            $users = $users->merge($bosses)->unique('id');
            
        } else {
            // Sin filtro, mostrar todos los usuarios activos
            $users = User::where('active', 1)->with('job')->get();
        }
        
        // Inicializar caché de sesión si se requiere conversión
        if ($convertImages && !session()->has('orgchart_image_cache')) {
            session()->put('orgchart_image_cache', []);
        }
        
        $defaultAvatar = asset('assets/images/default-avatar.svg');

        $dataEmployees = [];
        foreach ($users as $user) {

            if (!empty($user->job_id) && $user->job !== null) {
                $position = $user->job->name ?? 'Sin puesto asignado';
            } else {
                $position = 'Sin puesto asignado';
            }
            $tags = [];

            // Usar avatar por defecto si no tiene imagen
            $imageUrl = $user->profile_image ?: $defaultAvatar;

            // Si se solicita conversión de imágenes, convertir a base64
            if ($convertImages && $imageUrl && strpos($imageUrl, 'data:') !== 0) {
                $imageUrl = $this->convertImageToBase64($imageUrl);
            }

            $emp = [
                "id" => $user->id,
                "pid" => $user->boss_id,
                'tags' => $tags,
                "name" => trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: 'Sin nombre',
                "title" => $position,
                "img" => $imageUrl,
            ];

            array_push($dataEmployees, $emp);
           
        }

        return response()->json($dataEmployees);

    }

    /**
     * Convierte una URL de imagen a base64 con caché
     */
    private function convertImageToBase64($imageUrl)
    {
        try {
            // Verificar si ya es base64
            if (strpos($imageUrl, 'data:') === 0) {
                return $imageUrl;
            }

            // Verificar caché de sesión
            $cache = session()->get('orgchart_image_cache', []);
            $cacheKey = md5($imageUrl);
            
            if (isset($cache[$cacheKey])) {
                return $cache[$cacheKey];
            }

            // Descargar y convertir
            $imageContent = @file_get_contents($imageUrl);
            
            if ($imageContent === false) {
                return $imageUrl;
            }

            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($imageContent);
            $base64 = base64_encode($imageContent);
            
            $dataUri = "data:{$mimeType};base64,{$base64}";
            
            // Guardar en caché (limitar a 100 imágenes para no saturar)
            if (count($cache) < 100) {
                $cache[$cacheKey] = $dataUri;
                session()->put('orgchart_image_cache', $cache);
            }
            
            return $dataUri;
        } catch (\Exception $e) {
            return $imageUrl;
        }
    }

    public function getEmployeesByDepartment($departmentId)
    {
        // Obtener todos los usuarios activos del departamento
        $users = User::where('active', 1)
            ->whereHas('job', function($query) use ($departmentId) {
                $query->where('depto_id', $departmentId);
            })
            ->with('job')
            ->get();

        // También necesitamos los jefes de estos usuarios aunque no estén en el mismo departamento
        $bossIds = $users->pluck('boss_id')->filter()->unique();
        $bosses = User::whereIn('id', $bossIds)->where('active', 1)->with('job')->get();

        // Combinar ambos conjuntos
        $allUsers = $users->merge($bosses)->unique('id');

        $defaultAvatar = asset('assets/images/default-avatar.svg');

        $dataEmployees = [];
        foreach ($allUsers as $user) {
            if (!empty($user->job_id) && $user->job !== null) {
                $position = $user->job->name ?? 'Sin puesto asignado';
            } else {
                $position = 'Sin puesto asignado';
            }
            $tags = [];

            $emp = [
                "id" => $user->id,
                "pid" => $user->boss_id,
                'tags' => $tags,
                "name" => trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: 'Sin nombre',
                "title" => $position,
                "img" => $user->profile_image ?: $defaultAvatar,
            ];

            array_push($dataEmployees, $emp);
        }

        return response()->json($dataEmployees);
    }

    /**
     * Proxy para convertir imágenes externas a base64
     * Evita problemas de CORS en exportaciones
     */
    public function proxyImage(Request $request)
    {
        $imageUrl = $request->query('url');
        
        if (!$imageUrl) {
            return response()->json(['error' => 'URL no proporcionada'], 400);
        }

        try {
            // Descargar la imagen
            $imageContent = @file_get_contents($imageUrl);
            
            if ($imageContent === false) {
                return response()->json(['error' => 'No se pudo descargar la imagen'], 404);
            }

            // Detectar el tipo MIME
            $finfo = new \finfo(FILEINFO_MIME_TYPE);
            $mimeType = $finfo->buffer($imageContent);

            // Convertir a base64
            $base64 = base64_encode($imageContent);
            $dataUri = "data:{$mimeType};base64,{$base64}";

            return response()->json([
                'success' => true,
                'dataUri' => $dataUri
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error al procesar la imagen',
                'message' => $e->getMessage()
            ], 500);
        }
    }

}