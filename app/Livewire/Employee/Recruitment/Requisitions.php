<?php

namespace App\Livewire\Employee\Recruitment;

use Livewire\Component;
use App\Models\Recruitment\Requisition;

class Requisitions extends Component

{
    public $search = '';

    public $statusFilter = 'All';
    public $selectMode = false;
    public $selected = [];
    public $selectAll = false;

    public function enableSelection()
    {
        $this->selectMode = true;
    }

    public function disableSelection()
    {
        $this->selectMode = false;
        $this->selected = [];
        $this->selectAll = false;
    }

    public function updatedSelectAll($value)
    {
        $all = Requisition::latest()->pluck('id')->toArray();
        $this->selected = $value ? $all : [];
    }

    public function selectAllRows()
    {
        $all = Requisition::latest()->pluck('id')->toArray();
        $this->selected = count(array_diff($all, $this->selected)) ? $all : [];
        $this->selectAll = count(array_diff($all, $this->selected)) === 0;
    }

    public function acceptSelected()
    {
        if(!empty($this->selected)){
            Requisition::whereIn('id', $this->selected)
                ->update(['status' => 'Accepted']);
            $this->selected = [];
            $this->selectAll = false;
        }
    }

    public function draftSelected()
    {
        if(!empty($this->selected)){
            Requisition::whereIn('id', $this->selected)
                ->update(['status' => 'Draft']);
            $this->selected = [];
            $this->selectAll = false;
        }
    }

    public function accept($id)
    {
        $requisition = Requisition::findOrFail($id);
        $requisition->status = "Accepted";
        $requisition->save();
    }

    public function draft($id)
    {
        $requisition = Requisition::findOrFail($id);
        $requisition->status = "Draft";
        $requisition->save();
    }


    public function render()
    {
        $statusCounts = [
            'Open' => Requisition::where('status', 'Open')->count(),
            'Accepted' => Requisition::where('status', 'Accepted')->count(),
            'Draft' => Requisition::where('status', 'Draft')->count(),
            'All' => Requisition::count(),
        ];

        $query = Requisition::query()->latest();

        if ($this->statusFilter !== 'All') {
            $query->where('status', $this->statusFilter);
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('department', 'like', '%' . $this->search . '%')
                ->orWhere('requested_by', 'like', '%' . $this->search . '%');
            });
        }

        $requisitions = $query->get();

        return view('livewire.employee.recruitment.requisitions', [
            'statusCounts' => $statusCounts,
            'requisitions' => $requisitions,
        ]);
    }

}
