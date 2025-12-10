<?php

namespace App\Livewire\Employee\Social;

use Livewire\Component;

class Recognition extends Component
{
    public $showSearch = false;
    public $showForm = false;
    public $searchTerm = '';
    public $selectedEmployee = null;
    public $c_name;
    public $c_type;
    public $c_date;
    public $c_reward;
    public $recognitions;

    public function render()
    {
        return view('livewire.employee.social.recognition');
    }
}
