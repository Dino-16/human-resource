@extends('layouts.app')

@section('page-title', 'Recognition')
@section('page-subtitle', 'Review, approve, and manage all incoming job recognitions')
@section('breadcrumbs', 'recognitions')

@section('content')

<section>
    <div @class(['container-fluid'])>

        @livewire('employee.social.recognition')

    </div>
</section>

@endsection
