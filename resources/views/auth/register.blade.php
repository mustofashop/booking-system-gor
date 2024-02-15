@extends('layout.details.app', ['title' => 'IDI - Daftar'])

@section('content')
<div class="card card-danger">
    <div class="card-header">
        <h4 class="container text-center text-danger">Daftar Akun</h4>
    </div>

    <div class="card-body">
        <h4 class="container text-center text-success">Pendaftaran Admin di tutup</h4>
        <!-- <form method="POST" action="{{ route('register') }}">
            @csrf
            <div class="form-group">
                <label for="name">Nama</label>
                <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name">
                @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
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
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password" class="control-label">Konfirmasi Password</label>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password_confirmation">
                @error('password')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-danger btn-lg btn-block">
                    Daftar
                </button>
            </div>
        </form> -->
    </div>
</div>
<!-- <div class="mt-5 text-muted text-center text-danger">
    Sudah punya akun? <a class="text-danger" href="{{ route('login') }}">Masuk sekarang</a>
</div> -->
@endsection
