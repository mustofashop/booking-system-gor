@extends('layout.details.app', ['title' => 'E-Event - Register'])

@section('content')
<div class="card card-danger">
    <div class="card-header" style="display: flex; justify-content: space-between;">
        @foreach ($label as $item)
        @if ($item->code == 'register')
        <span>
        <h3 class="container text-dark">{!! html_entity_decode($item->title) !!}</h3>
        <p class="container text-dark">{!! html_entity_decode($item->desc) !!}</p>
    </span>
        @endif
        @endforeach
        <a href="/" class="btn btn-dark">
            <i class="fas fa-times"></i>
        </a>
    </div>

    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
        </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-8">
                    <label for="name">Name</label>
                    <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name"
                           value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-4">
                    <label for="username">Username</label>
                    <input id="username" type="username" class="form-control @error('username') is-invalid @enderror"
                           name="username" value="{{ old('username') }}">
                    @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group
                    col-md-8">
                    <label for="email">Email</label>
                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                           name="email" value="{{ old('email') }}">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group
                    col-md-4">
                    <label for="phone">Phone</label>
                    <input id="phone" type="phone" class="form-control @error('phone') is-invalid @enderror"
                           name="phone" value="{{ old('phone') }}">
                    @error('phone')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="password" class="control-label">Password</label>
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password" value="{{ old('password') }}">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group col-md-6">
                    <label for="password" class="control-label">Confirm Password</label>
                    <input id="password" type="password"
                           class="form-control @error('password') is-invalid @enderror"
                           name="password_confirmation" value="{{ old('password_confirmation') }}">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="form-group row">
                <div class="col-md-8">
                    @foreach ($button as $item)
                    @if ( $item->code == 'create')
                    <button type="submit" class="btn btn-danger btn-lg btn-block">
                        {!!html_entity_decode($item->title)!!}
                    </button>
                    @endif
                    @endforeach
                </div>
                <div class="col-md-4">
                    @foreach ($button as $item)
                    @if ( $item->code == 'login')
                    <a href="{{ route('login') }}" class="btn btn-dark btn-lg btn-block"><p style="font-size: 12px">
                            {!!html_entity_decode($item->title)!!}</p></a>
                    @endif
                    @endforeach
                </div>
            </div>
        </form>
    </div>

</div>
@endsection
