@extends('layout.details.app', ['title' => 'E-Event - Login'])

@section('content')
<div class="card card-danger">
    <div class="card-header">
        @foreach ($label as $item)
        @if ($item->code == 'login')
        <span>
            <h3 class="container text-dark">{!! html_entity_decode($item->title) !!}</h3>
            <p class="container text-dark">{!! html_entity_decode($item->desc) !!}</p>
        </span>
        @endif
        @endforeach
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email">
                @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="control-label">Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
                       name="password">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group row">
                <div class="col-8">
                    @foreach ($button as $item)
                    @if ( $item->code == 'login')
                    <button type="submit" class="btn btn-danger btn-lg btn-block">
                        {!!html_entity_decode($item->title)!!}
                    </button>
                    @endif
                    @endforeach
                </div>
                <div class="col-4">
                    @foreach ($button as $item)
                    @if ( $item->code == 'join')
                    <a href="{{ route('register') }}" class="btn btn-dark btn-lg btn-block"><p style="font-size: 12px">
                            {!!html_entity_decode($item->title)!!}</p></a>
                    @endif
                    @endforeach
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
