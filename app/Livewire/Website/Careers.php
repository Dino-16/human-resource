<?php

namespace App\Livewire\Website;

use Livewire\Component;
use App\Models\Recruitment\JobListing;
class Careers extends Component
{
    public $showDetails = false;

    public function viewDetails()
    {
        $this->showDetails = !$this->showDetails;
        $this->dispatch('detailsToggled');
    }

    public function remove()
    {
        $this->showDetails = false;
    }

    public function render()
    {

        $query = JobListing::query()->latest();

        $jobs = $query->get();

        return view('livewire.website.careers', [
            'jobs' => $jobs,
            'showDetails' => $this->showDetails
        ])->layout('layouts.website');
    }
}