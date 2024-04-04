@extends('layout.dashboard.app', ['title' => 'Profile Rider'])

@section('content')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'profile.create')
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

                    </div>
                </div>
                <div class="card-body">
                    <form id="fmlabel" action="{{ route('profile.store') }}" method="POST"
                          enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        <div class="row">
                            <!-- IMAGE -->
                            <div class="col-4">
                                <div id="image-preview" class="image-preview">
                                    <img id="preview" src="" alt="Image Preview"
                                         style="max-width: 100%; max-height: 200px; display: none;">
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="image" id="image-upload" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the image
                                    </div>
                                </div>
                            </div>
                            <!-- CODE -->
                            <div class="col-8">
                                <div class="row">
                                    <!-- NAME -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold">NAME</label>
                                            <input type="text" class="form-control" name="name"
                                                   value="{{ old('name') }}"
                                                   placeholder="Enter name" required="">
                                            <div class="invalid-feedback alert alert-danger mt-2">
                                                Please fill in the name
                                            </div>
                                        </div>
                                    </div>
                                    <!-- NICKNAME -->
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">NICKNAME</label>
                                            <input type="text" class="form-control" name="nickname"
                                                   value="{{ old('nickname') }}"
                                                   placeholder="Enter nickname" required="">
                                            <div class="invalid-feedback alert alert-danger mt-2">
                                                Please fill in the nickname
                                            </div>
                                        </div>
                                    </div>
                                    <!-- GENDER -->
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">GENDER</label>
                                            <select class="form-control select2" name="gender"
                                                    placeholder="Choose gender" required="">
                                                <option value="">-- Choose --</option>
                                                <option value="L">LAKI-LAKI
                                                </option>
                                                <option value="P">PEREMPUAN
                                                </option>
                                            </select>
                                            <div class="invalid-feedback alert alert-danger mt-2">
                                                Please fill in the status
                                            </div>
                                        </div>
                                    </div>
                                    <!-- PLACE -->
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">PLACE OF BIRTH</label>
                                            <input type="text" class="form-control" name="place"
                                                   value="{{ old('place') }}"
                                                   placeholder="Enter place" required="">
                                            <div class="invalid-feedback alert alert-danger mt-2">
                                                Please fill in the place
                                            </div>
                                        </div>
                                    </div>
                                    <!-- DATE -->
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">BIRTH DATE</label>
                                            <input type="date" class="form-control" name="date"
                                                   value="{{ old('date') }}"
                                                   placeholder="Enter date" required max="{{ date('Y-m-d') }}">
                                            <div class="invalid-feedback alert alert-danger mt-2">
                                                Please fill in the date
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-3" style="width:100%;text-align:left;margin-left:0; color:black">
                            <!-- HEIGHT -->
                            <div class="col-2">
                                <div class="form-group">
                                    <label class="font-weight-bold">HEIGHT</label>
                                    <input type="number" class="form-control" name="height"
                                           value="{{ old('height') }}"
                                           placeholder="Enter height" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the height
                                    </div>
                                </div>
                            </div>
                            <!-- WEIGHT -->
                            <div class="col-2">
                                <div class="form-group">
                                    <label class="font-weight-bold">WEIGHT</label>
                                    <input type="number" class="form-control" name="weight"
                                           value="{{ old('weight') }}"
                                           placeholder="Enter weight" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the weight
                                    </div>
                                </div>
                            </div>
                            <!-- PHONE -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">PHONE</label>
                                    <input type="number" class="form-control" name="phone"
                                           value="{{ old('phone', $user->phone) }}"
                                           placeholder="Enter phone" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the phone
                                    </div>
                                </div>
                            </div>
                            <!-- EMAIL -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">EMAIL</label>
                                    <input type="email" class="form-control" name="email"
                                           value="{{ old('email', $user->email) }}"
                                           placeholder="Enter email" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the email
                                    </div>
                                </div>
                            </div>
                            <!-- NUMBER PLATE -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">NUMBER PLATE</label>
                                    <input type="text" class="form-control" name="number_plat"
                                           value="{{ old('number_plat') }}"
                                           placeholder="Enter number plate" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the number plate
                                    </div>
                                </div>
                            </div>
                            <!-- NUMBER IDENTITY -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">NUMBER IDENTITY</label>
                                    <input type="text" class="form-control" name="number_identity"
                                           value="{{ old('number_identity') }}"
                                           placeholder="Enter number identity" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the number identity
                                    </div>
                                </div>
                            </div>
                            <!-- SOCMED -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">SOCMED</label>
                                    <input type="text" class="form-control" name="socmed"
                                           value="{{ old('socmed') }}"
                                           placeholder="Enter socmed" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the socmed
                                    </div>
                                </div>
                            </div>
                            <!-- BANNER -->
                            <div class="col-4">
                                <div id="image-preview" class="image-preview">
                                    <img id="preview-banner" src="" alt="Image Preview"
                                         style="max-width: 100%; max-height: 200px; display: none;">
                                    <label for="image-upload" id="banner-label">Choose File</label>
                                    <input type="file" name="banner" id="banner-upload" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the image
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="row">
                                    <!-- NATIONALITY -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold">NATIONALITY</label>
                                            <select class="form-control select2" name="nationality_id" placeholder="Choose nationality" required="">
                                                    <option value="">-- Choose --</option>
                                                    @foreach ($nations as $nation)
                                                        <option value="{{ $nation->id }}">{{ $nation->name }}</option>
                                                    @endforeach
                                                    </select>
                                            <div class="invalid-feedback alert alert-danger mt-2">
                                                Please fill in the nationality
                                            </div>
                                        </div>
                                    </div>
                                    <!-- ADDRESS -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold">ADDRESS</label>
                                            <textarea class="form-control" name="address" value="{{ old('address') }}"
                                                      placeholder="Enter address" required="">{{ old('address') }}</textarea>
                                            <div class="invalid-feedback alert alert-danger mt-2">
                                                Please fill in the address
                                            </div>
                                        </div>
                                    </div>
                                    <!-- STORY -->
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold">STORY</label>
                                            <textarea class="form-control" name="story" value="{{ old('story') }}"
                                                      placeholder="Enter story" required="">{{ old('story') }}</textarea>
                                            <div class="invalid-feedback alert alert-danger mt-2">
                                                Please fill in the story
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- BUTTON -->
                        <div class="form-group">
                            <button type="submit" style="width:100px" class="btn btn-success btn-action"
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
    });

    $(document).ready(function () {
        $('#banner-upload').change(function () {
            var file = this.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview-banner').attr('src', e.target.result).show();
                $('#banner-label').text(file.name);
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
    
    // Code to load banner when editing
    var imageUrl = '{{ isset($data->banner) ? asset("storage/rider/" . $data->banner) : "" }}';
    if (imageUrl) {
        $('#preview-banner').attr('src', imageUrl).show();
        $('#banner-label').text('Change File');
    }
</script>
@endsection
