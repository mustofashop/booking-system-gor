@extends('layout.dashboard.app', ['title' => 'Profile Rider'])

@section('content')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'profile.edit')
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
                    <h4>Edit</h4>
                    <div class="card-header-action">

                    </div>
                </div>
                <div class="card-body">
                    <form id="fmlabel" action="{{ route('user.profile.update', $data->id) }}" method="POST"
                          enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- IMAGE -->
                            <div class="col-4">
                                <div id="image-preview" class="image-preview"
                                     data-image-url="{{ isset($data->image) ? asset('storage/rider/' . $data->image) : '' }}">
                                    <img id="preview"
                                         src="{{ isset($data->image) ? asset('storage/rider/' . $data->image) : '' }}"
                                         alt="Image Preview" style="max-width: 100%; max-height: 200px; display: none;">
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="image" id="image-upload">
                                </div>
                            </div>
                            <!-- CODE -->
                            <div class="col-8">
                                <div class="row">
                                    <!-- CODE -->
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label class="font-weight-bold">CODE</label>
                                            <input type="text" class="form-control" name="code"
                                                   value="{{ $data->code }}"
                                                   placeholder="Enter code" required="" readonly>
                                            <div class="invalid-feedback alert alert-danger mt-2">
                                                Please fill in the code
                                            </div>
                                        </div>
                                    </div>
                                    <!-- NAME -->
                                    <div class="col-10">
                                        <div class="form-group">
                                            <label class="font-weight-bold">NAME</label>
                                            <input type="text" class="form-control" name="name"
                                                   value="{{ $data->name }}"
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
                                                   value="{{ $data->nickname }}"
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
                                                <option value="L" {{ $data->gender == 'L' ? 'selected' : ''
                                                    }}>LAKI-LAKI
                                                </option>
                                                <option value="P" {{ $data->gender == 'P' ? 'selected' : ''
                                                    }}>PEREMPUAN
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
                                                   value="{{ $data->place }}"
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
                                                   value="{{ $data->date }}"
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
                                           value="{{ $data->height }}"
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
                                           value="{{ $data->weight }}"
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
                                           value="{{ $data->phone }}"
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
                                           value="{{ $data->email }}"
                                           placeholder="Enter email" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the email
                                    </div>
                                </div>
                            </div>
                            <!-- ADDRESS -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">ADDRESS</label>
                                    <textarea class="form-control" name="address" value="{{ old('address') }}"
                                              placeholder="Enter address" required="">{{ old('address', $data->address) }}</textarea>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the address
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

    // Code to load image when editing
    var imageUrl = '{{ isset($data->image) ? asset("storage/rider/" . $data->image) : "" }}';
    if (imageUrl) {
        $('#preview').attr('src', imageUrl).show();
        $('#image-label').text('Change File');
    }
</script>
@endsection
