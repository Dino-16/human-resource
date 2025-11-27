<?php

namespace App\Livewire\Employee\Recruitment;

use Livewire\Component;
use App\Models\Recruitment\Requisition;
class Requisitions extends Component
{
    public function render()
    {
        return view('livewire.employee.recruitment.requisitions');
    }
    public function accept(){

        $requisition = Requisition::findOrFail($id);
        $requisition->status = "Acceptad";
        $requisition->save();
    }
}
