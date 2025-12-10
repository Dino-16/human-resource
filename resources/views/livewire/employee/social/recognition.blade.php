<div @class('pt-2')>

    <div @class('d-flex justify-content-between align-items-center')>

        {{-- left side --}}
        <div @class('mb-3 d-flex justify-content-between align-items-center')>
            {{-- with check Bar --}}
            <div @class('mb-3 ')>
                <button class="btn btn-primary" wire:click="$toggle('showSearch')">CREATE RECOGNITON</button>
            </div>
        </div>

    </div>

    @if ($showSearch)
        {{-- SEARCH / EMPLOYEE SELECTION --}}
        <div @class('p-4 bg-white rounded border mb-3')>
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="Search employee..." wire:model="">
            </div>

            {{-- Employee Cards (3 per row) --}}
            <div class="row g-3">

                    <div class="col-md-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title">hjklh</h5>
                                <p class="card-text text-secondary">Position:</p>
                                <button class="btn btn-success btn-sm" wire:click="">
                                    Select for Recognition
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center text-muted">
                        No employees found.
                    </div>

            </div>
        </div>

    @elseif ($showForm)
                <div>

                <div class="row pt-1">
                    {{-- Recognition Form --}}
                    <div class="col-md-7">
                        <div class="card p-5">
                            <h2>Create Recognition</h2>

                            <form wire:submit.prevent="submitRecognition">
                                <div class="row">
                                    <div class="col-md-12 mb-5">
                                        <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                                                style="width:80px; height:80px; font-size:32px; font-weight:bold;">
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-5">
                                        <label>Name</label>
                                        <input type="text" class="form-control" wire:model.defer="c_name">
                                        @error('c_name') <span class="text-danger"></span> @enderror
                                    </div>

                                    <div class="col-md-6 mb-5">
                                        <label>Recognition Type</label>
                                        <input type="text" class="form-control" wire:model.defer="c_type">
                                        @error('c_type') <span class="text-danger"></span> @enderror
                                    </div>

                                    <div class="col-md-6 mb-5">
                                        <label>Date</label>
                                        <input type="date" class="form-control" wire:model.defer="c_date">
                                        @error('c_date') <span class="text-danger"></span> @enderror
                                    </div>

                                    <div class="col-md-12 mb-5">
                                        <label>Reward</label>
                                        <input class="form-control" wire:model.defer="c_reward">
                                        @error('c_reward') <span class="text-danger"></span> @enderror
                                    </div>

                                    <div class="col-md-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    {{-- Recent Recognitions --}}
                    <div class="col-md-5">
                        <h2>Rewards</h2>
                        <div class="row">
                            <div class="col-md-12">

                                    <div class="row align-items-center border p-3 mb-3 rounded">

                                        <div class="col-sm-2 d-flex justify-content-center align-items-center">
                                            <div class="rounded-circle bg-primary text-white d-flex justify-content-center align-items-center"
                                                style="width:80px; height:80px; font-size:32px; font-weight:bold;">

                                            </div>
                                        </div>

                                        <div class="col-sm-7">
                                            <h5></h5>
                                            <h6 class="text-muted"></h6>
                                            <p></p>
                                            <p class="text-muted small"></p>
                                        </div>

                                        <div class="col-sm-3 d-flex flex-column gap-2">
                                            <button class="btn btn-outline-primary btn-sm" wire:click="edit">Edit</button>
                                            <button class="btn btn-danger btn-sm" wire:click="delete">Delete</button>
                                        </div>
                                    </div>
                                    <div class="text-center text-muted">No latest recognitions yet.</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
    @else
        {{-- Table Title --}}
        <div @class('p-5 bg-white rounded border rounded-bottom-0 border-bottom-0')>
            <div>
                <h3>All Recognition</h3>
                <p @class('text-secondary mb-0')>
                    Overview of recognitions
                </p>
            </div>
        </div>

        {{-- Table --}}
        <div @class('table-responsive border rounded bg-white px-5 rounded-top-0 border-top-0')>
            <table @class('table')>
                <thead>
                    <tr @class('bg-dark')>

                        <th @class('text-secondary fw-normal') scope="col">ID</th>
                        <th @class('text-secondary fw-normal') scope="col">Employee Name</th>
                        <th @class('text-secondary fw-normal') scope="col">Recognition Type</th>
                        <th @class('text-secondary fw-normal') scope="col">Reward</th>
                        <th @class('text-secondary fw-normal') scope="col">Date</th>
                        <th @class('text-secondary fw-normal') scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                        <tr>

                            <td @class('text-nowrap')></td>
                            <td @class('text-truncate')></td>
                            <td @class('text-capitalize')></td>
                            <td @class('text-start')></td>
                            <td @class('text-start')></td>

                        <td class="text-nowrap">
                                <button type="button" class="btn btn-default border btn-sm" wire:click="" title="edit">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <button type="button" class="btn btn-default border btn-sm" wire:click="" title="delete">
                                    <i class="bi bi-trash3-fill"></i>
                                </button>
                            </td>

                        </tr>

                        <tr>
                            <td colspan="7" @class('text-center text-muted')>No recogniton found.</td>
                        </tr>

                </tbody>
            </table>
        </div>
    @endif

</div>



