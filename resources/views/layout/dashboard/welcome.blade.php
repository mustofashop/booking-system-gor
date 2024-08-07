@extends('layout.dashboard.app', ['title' => 'E-Event - Dashboard'])

@section('content')
@include('layout.dashboard.partials.alert')
<div class="container-fluid">
    <div class="row text-center">
        <div class="col-sm-12">
            <img src="{{ asset('assets/img/sports2.png') }}" alt="logo" class="img-fluid" style="width: 700px;">
            <h1 class="m-1">Booking System | Sports Field</h1>
            <h3 class="m-1">Version 1.0.0</h3>
        </div>
    </div>
</div>
@endsection
