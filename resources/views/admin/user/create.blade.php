@extends('layout.dashboard.app', ['title' => 'Create User'])

@section('content')

{{-- Alert Messages --}}
@include('layout.dashboard.partials.alert')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'user.create')
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
            <div class="card border-0 shadow rounded">
                <div class="card-header">
                    <h4>Create</h4>
                    <div class="card-header-action">
                        <a href="{{ route('user.index') }}" class="btn btn-warning" data-toggle="tooltip"
                           title="Back"><i class="fas fa-backward"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="fmuser" action="{{ route('user.store') }}" method="POST"
                          enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        <div class="row">
                            <!-- NAME -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">NAME</label>
                                    <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                           placeholder="Enter name" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the name
                                    </div>
                                </div>
                            </div>
                            <!-- USERNAME -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">USERNAME</label>
                                    <input type="text" class="form-control" name="username"
                                           value="{{ old('username') }}"
                                           placeholder="Enter username" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the username
                                    </div>
                                </div>
                            </div>
                            <!-- EMAIL -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">EMAIL</label>
                                    <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                                           placeholder="Enter email" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the email
                                    </div>
                                </div>
                            </div>
                            <!-- PHONE -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">PHONE</label>
                                    <input type="number" class="form-control" name="phone" value="{{ old('phone') }}"
                                           placeholder="Enter phone" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the phone
                                    </div>
                                </div>
                            </div>
                            <!-- PASSWORD -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">PASSWORD</label>
                                    <input type="text" class="form-control" name="password"
                                           value="{{ old('password','123456789') }}"
                                           placeholder="Enter password" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the password
                                    </div>
                                </div>
                            </div>
                            <!-- CONFIRM PASSWORD -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">CONFIRM PASSWORD</label>
                                    <input type="text" class="form-control" name="password_confirmation"
                                           value="{{ old('password_confirmation','123456789') }}"
                                           placeholder="Enter confirm password" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the confirm password
                                    </div>
                                </div>
                            </div>
                            <!-- PERMISSION -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">PERMISSION</label>
                                    <select class="form-control select2" name="permission"
                                            value="{{ old('permission') }}"
                                            placeholder="Pilih jabatan" required="">
                                        <option value="">-- Choose --</option>
                                        @foreach($permission as $item)
                                        <option value="{{ $item->level }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the permission
                                    </div>
                                </div>
                            </div>
                            <!-- STATUS -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">STATUS</label>
                                    <select class="form-control select2" name="status" value="{{ old('status') }}"
                                            placeholder="Pilih status" required="">
                                        <option value="">-- Choose --</option>
                                        <option value="ACTIVE">ACTIVE</option>
                                        <option value="INACTIVE">INACTIVE</option>
                                    </select>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the status
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- BUTTON -->
                        <div class="form-group">
                            <button type="submit" style="width:100px" class="btn btn-danger btn-action"
                                    data-toggle="tooltip" title="Save"><i class="fas fa-save"></i></button>
                            <button type="reset" onclick="myReset()" class="btn btn-dark btn-action"
                                    data-toggle="tooltip" title="Reset"><i class="fas fa-redo-alt"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
