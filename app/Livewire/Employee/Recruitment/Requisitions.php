<?php

namespace App\Livewire\Employee\Recruitment;

use Livewire\Component;
use App\Models\Recruitment\Requisition;
use App\Exports\RequisitionsExport;
use Livewire\WithPagination;

class Requisitions extends Component
{
    use WithPagination;

    public $search;
    public $statusFilter = 'All';
    public $showDrafts = false;

    // Always reset pagination when filters change
    public function updatedSearch() { $this->resetPage(); }
    public function updatedStatusFilter() { $this->resetPage(); }

    public function accept($id)
    {
        $req = Requisition::findOrFail($id);
        $req->status = "Accepted";
        $req->save();
    }

    public function draft($id)
    {
        $req = Requisition::findOrFail($id);
        $req->status = "Draft";
        $req->save();
    }

    public function export()
    {
        return (new RequisitionsExport)->download('requisition.xlsx');
    }

    // Show Draft table
    public function openDraft()
    {
        $this->showDrafts = true;
        $this->resetPage();
    }

    public function restore($id) {
        $draft = Requisition::findOrFail($id);
        $draft->status == 'Open';
    }

    // Go back to full list
    public function showAll()
    {
        $this->showDrafts = false;
        $this->resetPage();
    }

    public function render()
    {
        // Status counts on top
        $statusCounts = [
            'Open'     => Requisition::where('status', 'Open')->count(),
            'Accepted' => Requisition::where('status', 'Accepted')->count(),
            'Draft'    => Requisition::where('status', 'Draft')->count(),
            'All'      => Requisition::count(),
        ];

        // 🔹 If showing Draft page only
        if ($this->showDrafts) {
            $drafts = Requisition::where('status', 'Draft')
                ->latest()
                ->paginate(10);

            return view('livewire.employee.recruitment.requisitions', [
                'statusCounts' => $statusCounts,
                'requisitions' => null,
                'drafts'       => $drafts,
            ]);
        }

        // 🔹 Main table with filters and search
        $query = Requisition::query()->latest();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('department', 'like', "%{$this->search}%")
                  ->orWhere('requested_by', 'like', "%{$this->search}%");
            });
        }

        if ($this->statusFilter !== 'All') {
            $query->where('status', $this->statusFilter);
        }

        $requisitions = $query->paginate(10);

        return view('livewire.employee.recruitment.requisitions', [
            'statusCounts' => $statusCounts,
            'requisitions' => $requisitions,
            'drafts'       => null,
        ]);
    }
}