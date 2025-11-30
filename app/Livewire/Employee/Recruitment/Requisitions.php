<?php

namespace App\Livewire\Employee\Recruitment;

use Livewire\Component;
use App\Models\Recruitment\Requisition;

class Requisitions extends Component
{
    public function accept()
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
