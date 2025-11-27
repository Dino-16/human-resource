<?php

namespace App\Livewire\Employee\Recruitment;

use Livewire\Component;
use App\Models\Recruitment\Requisition;

class Requisitions extends Component
{
    public function accept()
    {
        $requisition = Requisition::findOrFail($id);
        $requisition->status = "Acceptad";
        $requisition->save();
    }

    public function render()
    {
        $requisition = Requisition::latest();

        return view('livewire.employee.recruitment.requisitions', [
            'requisition' => $requisition,
        ]);
    }

}
