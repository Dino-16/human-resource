@extends('layouts.website')

@section('content')
    @livewire('website.application-form', ['id' => $id])
@endsection