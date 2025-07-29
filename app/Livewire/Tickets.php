<?php

namespace App\Livewire;

use App\Models\Ticket;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Tickets extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = '';
    public int $perPage = 10;

    protected $queryString = [
        'search' => ['except' => ''],
        'status' => ['except' => ''],
        'perPage' => ['except' => 10],
    ];

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatus(): void
    {
        $this->resetPage();
    }

    public function render(): View
    {
        $user = auth()->user();
        $query = Ticket::query()->with(['user', 'organization']);

        // Filter by organization for regular users and admins
        if ($user->role !== 'super-admin') {
            $query->where('organization_id', $user->organization_id);

            // Regular users can only see their own tickets
            if ($user->role !== 'admin') {
                $query->where('user_id', $user->id);
            }
        }

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('subject', 'like', '%' . $this->search . '%')
                  ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        // Apply status filter
        if ($this->status) {
            $query->where('status', $this->status);
        }

        $tickets = $query->orderBy('created_at', 'desc')
                         ->paginate($this->perPage);

        return view('livewire.tickets', [
            'tickets' => $tickets,
        ]);
    }
}
