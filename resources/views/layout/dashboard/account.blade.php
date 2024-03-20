@extends('layout.dashboard.app', ['title' => 'Edit Member'])

@section('content')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'account')
    <div class="section-title">
        <h3>{!! html_entity_decode($item->title) !!}</h3>
    </div>
    <p class="section-lead">
        {!! html_entity_decode($item->desc) !!}
    </p>
    @endif
    @endforeach
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Change</h4>
                <div class="card-header-action">
                    <a href="{{ route('member.index') }}" class="btn btn-warning" data-toggle="tooltip"
                       title="Back"><i class="fas fa-backward"></i></a>
                </div>
            </div>
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-5">
                    <div class="card profile-widget">
                        <div class="profile-widget-header">
                            <img alt="image" src="assets/img/avatar/avatar-2.png"
                                 class="rounded-circle profile-widget-picture">
                            <div class="profile-widget-items">
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Permission</div>
                                    <div class="profile-widget-item-value">{{ $data->permission }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Status</div>
                                    <div class="profile-widget-item-value">{{ $data->status }}</div>
                                </div>
                                <div class="profile-widget-item">
                                    <div class="profile-widget-item-label">Joined</div>
                                    <div class="profile-widget-item-value">{{ date('d F Y',
                                        strtotime($data->created_at)) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <form method="post" class="needs-validation" novalidate=""
                              action="{{ route('account.reset', $data->id) }}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h4>Change Password</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- OLD PASSWORD -->
                                    <div class="form-group col-12">
                                        <label for="old_password">Old Password</label>
                                        <input id="old_password" type="password" class="form-control"
                                               name="old_password"
                                               required autofocus>
                                        <div class="invalid-feedback">
                                            Please fill in the old password
                                        </div>
                                    </div>
                                    <!-- PASSWORD -->
                                    <div class="form-group col-12">
                                        <label for="password">Password</label>
                                        <input id="password" type="password" class="form-control" name="password"
                                               required>
                                        <div class="invalid-feedback">
                                            Please fill in the password
                                        </div>
                                    </div>
                                    <!-- CONFIRM PASSWORD -->
                                    <div class="form-group col-12">
                                        <label for="password">Confirm Password</label>
                                        <input id="password" type="password" class="form-control" name="password"
                                               required>
                                        <div class="invalid-feedback">
                                            Please fill in the password
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-success">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-7">
                    <div class="card">
                        <form method="post" class="needs-validation" novalidate=""
                              action="{{ route('account.update', $data->id) }}"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="card-header">
                                <h4>Update Account</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <!-- NAME -->
                                    <div class="form-group col-md-7 col-12">
                                        <label for="name">Name</label>
                                        <input id="name" type="text" class="form-control" name="name"
                                               value="{{ $data->name }}" required autofocus>
                                        <div class="invalid-feedback">
                                            Please fill in the name
                                        </div>
                                    </div>
                                    <!-- USERNAME -->
                                    <div class="form-group  col-md-5 col-12">
                                        <label for="username">Username</label>
                                        <input id="username" type="text" class="form-control" name="username"
                                               value="{{ $data->username }}" required>
                                        <div class="invalid-feedback">
                                            Please fill in the username
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <!-- EMAIL -->
                                    <div class="form-group col-md-7 col-12">
                                        <label for="email">Email</label>
                                        <input id="email" type="email" class="form-control" name="email"
                                               value="{{ $data->email }}" required>
                                        <div class="invalid-feedback">
                                            Please fill in the email
                                        </div>
                                    </div>
                                    <!-- PHONE -->
                                    <div class="form-group col-md-5 col-12">
                                        <label for="phone">Phone</label>
                                        <input id="phone" type="number" class="form-control" name="phone"
                                               value="{{ $data->phone }}" required>
                                        <div class="invalid-feedback">
                                            Please fill in the phone
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-success">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#image-upload').change(function () {
            var file = this.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result).show();
                $('#image-label').text(file.name);
            };

            reader.readAsDataURL(file);
        });

        $('#image-banner').change(function () {
            var file = this.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview2').attr('src', e.target.result).show();
                $('#image-label2').text(file.name);
            };

            reader.readAsDataURL(file);
        });
    });

    // Code to load image when editing
    var imageUrl = '{{ isset($data->image) ? asset("storage/rider/" . $data->image) : "" }}';
    if (imageUrl) {
        $('#preview').attr('src', imageUrl).show();
        $('#image-label').text('Change File');
    }
</script>

@endsection
