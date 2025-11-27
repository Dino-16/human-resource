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

    public function render()
    {
        $requisitions = Requisition::latest()->get();

        return view('livewire.employee.recruitment.requisitions', [
            'requisitions' => $requisitions,
        ]);
    }

}
