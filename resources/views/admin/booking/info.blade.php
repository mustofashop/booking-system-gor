@extends('layout.dashboard.app', ['title' => 'Information'])

@section('content')
<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'booking')
    <div class="section-title">
        <h3>{!! html_entity_decode($item->title) !!}</h3>
    </div>
    <p class="section-lead">
        {!! html_entity_decode($item->desc) !!}
    </p>
    @endif
    @endforeach
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Information</h4>
                    <div class="card-header-action">
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="container-fluid">
                        <div class="row text-center">
                            <div class="col-sm-12 m-5">
                                <img src="{{ asset('assets/img/welcome.png') }}" alt="logo" class="img-fluid"
                                     style="width: 350px;">
                                <h1 class="m-1">Booking System | Push Bike Event</h1>
                                <h3 class="m-1">Version 1.0.0</h3>
                                <p class="m-1">Welcome to the booking system, please complete your profile first</p>
                                <a href="/profile" class="btn btn-dark m-1">Setup Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
