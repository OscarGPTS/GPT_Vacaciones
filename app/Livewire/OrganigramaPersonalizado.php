<?php

namespace App\Livewire;

use App\Models\CustomOrgchart;
use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\On;
use WireUI\Traits\Actions;

class OrganigramaPersonalizado extends Component
{
    use Actions;

    public bool $showModal = false;
    public ?int $editingId = null;

    // Form fields
    public string $title = '';
    public string $description = '';

    // In-memory nodes: [{user_id, user_name, user_img, label, parent_id}]
    public array $nodes = [];

    // Add-node sub-form
    public string $searchUser = '';
    public ?int $selectedUserId = null;
    public string $nodeLabel = '';
    public ?int $nodeParentId = null;

    protected $rules = [
        'title'       => 'required|string|min:3|max:150',
        'description' => 'nullable|string|max:255',
    ];

    // -----------------------------------------------------------------------
    // Open / Close
    // -----------------------------------------------------------------------

    public function openCreate(): void
    {
        $this->reset(['editingId', 'title', 'description', 'nodes',
                       'searchUser', 'selectedUserId', 'nodeLabel', 'nodeParentId']);
        $this->showModal = true;
        $this->dispatchPreview();
    }

    #[On('editOrgchart')]
    public function openEdit(int $id): void
    {
        if (! auth()->user()->can('ver modulo rrhh')) {
            return;
        }

        $chart = CustomOrgchart::where('is_active', true)->findOrFail($id);

        $this->editingId   = $id;
        $this->title       = $chart->title;
        $this->description = $chart->description ?? '';

        $this->nodes = collect($chart->nodes ?? [])->map(function ($node) {
            $user = User::find($node['id']);
            return [
                'user_id'   => $node['id'],
                'user_name' => $user
                    ? trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''))
                    : 'Usuario #' . $node['id'],
                'user_img'  => $user
                    ? ($user->profile_image ?: asset('assets/images/default-avatar.svg'))
                    : asset('assets/images/default-avatar.svg'),
                'label'     => $node['label'] ?? '',
                'parent_id' => $node['pid'],
            ];
        })->toArray();

        $this->reset(['searchUser', 'selectedUserId', 'nodeLabel', 'nodeParentId']);
        $this->showModal = true;
        $this->dispatchPreview();
    }

    // -----------------------------------------------------------------------
    // Delete
    // -----------------------------------------------------------------------

    #[On('deleteOrgchart')]
    public function deleteChart(int $id): void
    {
        if (! auth()->user()->can('ver modulo rrhh')) {
            return;
        }

        CustomOrgchart::where('is_active', true)->findOrFail($id)->delete();

        $this->notification()->success('Eliminado', 'El organigrama fue eliminado correctamente.');
        $this->dispatch('refreshOrgcharts');
    }

    // -----------------------------------------------------------------------
    // User search / selection
    // -----------------------------------------------------------------------

    public function selectUser(int $userId): void
    {
        $user = User::find($userId);
        if (! $user) {
            return;
        }

        $this->selectedUserId = $userId;
        $this->searchUser     = trim(($user->last_name ?? '') . ' ' . ($user->first_name ?? ''));

        // Auto-fill label with job name when empty
        if (empty($this->nodeLabel) && $user->job) {
            $this->nodeLabel = $user->job->name;
        }
    }

    // -----------------------------------------------------------------------
    // Node management
    // -----------------------------------------------------------------------

    public function addNode(): void
    {
        if (! $this->selectedUserId) {
            $this->notification()->error('Error', 'Selecciona un usuario primero.');
            return;
        }

        if (collect($this->nodes)->firstWhere('user_id', $this->selectedUserId)) {
            $this->notification()->error('Error', 'Este usuario ya está en el organigrama.');
            return;
        }

        $user = User::with('job')->find($this->selectedUserId);
        if (! $user) {
            return;
        }

        $this->nodes[] = [
            'user_id'   => $this->selectedUserId,
            'user_name' => trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')),
            'user_img'  => $user->profile_image ?: asset('assets/images/default-avatar.svg'),
            'label'     => $this->nodeLabel ?: ($user->job?->name ?? 'Sin rol'),
            'parent_id' => $this->nodeParentId,
        ];

        $this->reset(['searchUser', 'selectedUserId', 'nodeLabel', 'nodeParentId']);
        $this->dispatchPreview();
    }

    public function removeNode(int $userId): void
    {
        // Remove node and orphan its children (move them to root)
        $this->nodes = collect($this->nodes)
            ->filter(fn ($n) => $n['user_id'] !== $userId)
            ->map(function ($n) use ($userId) {
                if ($n['parent_id'] === $userId) {
                    $n['parent_id'] = null;
                }
                return $n;
            })
            ->values()
            ->toArray();

        $this->dispatchPreview();
    }

    // -----------------------------------------------------------------------
    // Save
    // -----------------------------------------------------------------------

    public function save(): void
    {
        $this->validate();

        if (empty($this->nodes)) {
            $this->notification()->error('Error', 'Agrega al menos un integrante al organigrama.');
            return;
        }

        $storedNodes = collect($this->nodes)->map(fn ($n) => [
            'id'    => $n['user_id'],
            'pid'   => $n['parent_id'],
            'label' => $n['label'],
        ])->toArray();

        $data = [
            'title'       => $this->title,
            'description' => $this->description,
            'nodes'       => $storedNodes,
            'created_by'  => auth()->id(),
        ];

        if ($this->editingId) {
            CustomOrgchart::findOrFail($this->editingId)->update($data);
            $this->notification()->success('Actualizado', 'El organigrama fue actualizado correctamente.');
        } else {
            CustomOrgchart::create($data);
            $this->notification()->success('Creado', 'El organigrama personalizado fue creado.');
        }

        $this->showModal = false;
        $this->dispatch('refreshOrgcharts');
    }

    // -----------------------------------------------------------------------
    // Computed: search results
    // -----------------------------------------------------------------------

    public function getSearchResultsProperty()
    {
        if (strlen(trim($this->searchUser)) < 2 || $this->selectedUserId) {
            return collect();
        }

        $term       = $this->searchUser;
        $excludeIds = collect($this->nodes)->pluck('user_id')->toArray();

        return User::where('active', 1)
            ->where(function ($q) use ($term) {
                $q->where('first_name', 'like', "%{$term}%")
                  ->orWhere('last_name', 'like', "%{$term}%")
                  ->orWhereRaw("CONCAT(first_name, ' ', last_name) like ?", ["%{$term}%"])
                  ->orWhereRaw("CONCAT(last_name, ' ', first_name) like ?", ["%{$term}%"]);
            })
            ->whereNotIn('id', $excludeIds)
            ->with('job')
            ->orderBy('last_name')
            ->limit(8)
            ->get();
    }

    // -----------------------------------------------------------------------
    // Preview broadcast
    // -----------------------------------------------------------------------

    private function dispatchPreview(): void
    {
        $previewNodes = collect($this->nodes)->map(fn ($n) => [
            'id'    => $n['user_id'],
            'pid'   => $n['parent_id'],
            'name'  => $n['user_name'],
            'title' => $n['label'] ?: 'Sin rol',
            'img'   => $n['user_img'],
        ])->values()->toArray();

        $this->dispatch('orgchartPreviewUpdated', nodes: $previewNodes);
    }

    public function render()
    {
        return view('livewire.organigrama-personalizado');
    }
}
