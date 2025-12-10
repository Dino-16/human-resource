<?php

namespace App\Livewire\Website;

use Livewire\Component;
use App\Models\Recruitment\JobListing;
class Careers extends Component
{
    public $showDetails = false;
    public $selectedJob;

    public function viewDetails($id)
    {
        $this->selectedJob = JobListing::find($id);
        $this->showDetails = true;
    }

    public function remove()
    {
        $this->showDetails = false;
        $this->selectedJob = null;
    }

    public function render()
    {

        $query = JobListing::query()->latest();

        $jobs = $query->get();

        return view('livewire.website.careers', [
            'jobs' => $jobs,
            'selectedJob' => $this->selectedJob,
            'showDetails' => $this->showDetails
        ]);
    }
}