<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\User;
use Illuminate\Http\Request;

class AdminImpersonateController extends Controller
{
    private function realAdminId(): int
    {
        return (int) (session('impersonate_original_id') ?? auth()->id());
    }

    private function ensureSuperAdmin(): void
    {
        $admin = User::find($this->realAdminId());
        if (!$admin || !$admin->hasRole('super-admin')) {
            abort(403, 'Acceso denegado.');
        }
    }

    public function index(Request $request)
    {
        $this->ensureSuperAdmin();

        $search     = trim($request->input('search', ''));
        $deptFilter = $request->input('department');

        $users = User::with(['job.departamento'])
            ->where('active', 1)
            ->when($search !== '', function ($q) use ($search) {
                // Search by ID (exact) or by name/email (partial)
                if (is_numeric($search)) {
                    $q->where(function ($q2) use ($search) {
                        $q2->where('id', $search)
                           ->orWhere('first_name', 'like', "%{$search}%")
                           ->orWhere('last_name',  'like', "%{$search}%")
                           ->orWhere('email',      'like', "%{$search}%");
                    });
                } else {
                    $q->where(function ($q2) use ($search) {
                        $q2->where('first_name', 'like', "%{$search}%")
                           ->orWhere('last_name',  'like', "%{$search}%")
                           ->orWhere('email',      'like', "%{$search}%");
                    });
                }
            })
            ->when($deptFilter, function ($q) use ($deptFilter) {
                $q->whereHas('job', function ($q2) use ($deptFilter) {
                    $q2->where('departamento_id', $deptFilter);
                });
            })
            ->orderBy('first_name')
            ->orderBy('last_name')
            ->paginate(15)
            ->withQueryString();

        $departments = Departamento::orderBy('name')->get();

        $currentlyImpersonating = session('impersonate_user_id')
            ? User::find(session('impersonate_user_id'))
            : null;

        return view('admin.impersonate.index', compact(
            'users', 'search', 'deptFilter', 'departments', 'currentlyImpersonating'
        ));
    }

    public function start(int $userId)
    {
        $this->ensureSuperAdmin();

        $target = User::findOrFail($userId);

        session([
            'impersonate_user_id'     => $target->id,
            'impersonate_original_id' => $this->realAdminId(),
        ]);

        return redirect()->route('vacaciones.index');
    }

    public function stop()
    {
        session()->forget(['impersonate_user_id', 'impersonate_original_id']);

        return redirect()->route('admin.impersonate.index')
            ->with('success', 'Sesión de prueba finalizada.');
    }
}
