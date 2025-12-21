@extends('layouts.app')

@section('page-title', 'Travel Job-Posting')
@section('page-subtitle', 'Review and manage incoming job requisitions.')
@section('breadcrumbs', 'Job-Posting')

@section('content')
<section>
    <div @class('container-fluid')>

        @livewire('employee.applicants.applications')

    </div>
@endsection
