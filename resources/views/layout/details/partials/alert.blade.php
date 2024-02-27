{{-- Message --}}
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="bx bx-window-close"></i>
    </button>
    <strong>Berhasil !</strong> {{ session('success') }}
</div>
@endif

{{-- menampilkan error validasi --}}
@if (count($errors) > 0)
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="bx bx-window-close"></i>
    </button>
    <strong>Gagal !</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif