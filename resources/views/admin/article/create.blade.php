@extends('layout.dashboard.app', ['title' => 'Create Article'])

@section('content')
    <section class="section">
        @foreach ($label as $item)
            @if ($item->code == 'article.create')
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
                            <a href="{{ route('article.index') }}" class="btn btn-warning" data-toggle="tooltip"
                                title="Back"><i class="fas fa-backward"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form id="fmabt" action="{{ route('article.store') }}" method="POST"
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
                                <div class="col-4">
                                    <div id="image-preview" class="image-preview">
                                        <img id="preview2" src="" alt="Image Preview"
                                            style="max-width: 100%; max-height: 200px; display: none;">
                                        <label for="image-upload2" id="image-label2">Choose File</label>
                                        <input type="file" name="image2" id="image-upload2" required="">
                                        <div class="invalid-feedback alert alert-danger mt-2">
                                            Please fill in the image
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div id="image-preview" class="image-preview">
                                        <img id="preview3" src="" alt="Image Preview"
                                            style="max-width: 100%; max-height: 200px; display: none;">
                                        <label for="image-upload3" id="image-label2">Choose File</label>
                                        <input type="file" name="image3" id="image-upload3" required="">
                                        <div class="invalid-feedback alert alert-danger mt-2">
                                            Please fill in the image
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br>
                            <!-- DETAIL -->
                            <div class="row">
                                <!-- CATEGORY -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="category_id" class="font-weight-bold">CHOOSE CATEGORY <span
                                                class="text-danger">*</span></label>
                                        <select id="category_id" name="category_id" class="select2 form-control"
                                            required="">
                                            <option value="">Choose</option>
                                            @foreach ($category as $item)
                                                <option value="{{ $item->id }}"> {{ $item->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div class="invalid-feedback">
                                            Please select a valid member
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- TITLE -->
                                <div class="col-6 mt-3">
                                    <div class="form-group">
                                        <label class="font-weight-bold">TITLE
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="title"
                                            value="{{ old('title') }}" placeholder="Enter title" required="">
                                        <div class="invalid-feedback alert alert-danger mt-2">
                                            Please fill in the title
                                        </div>
                                    </div>
                                </div>
                                <!-- STATUS -->
                                <div class="col-6 mt-3">
                                    <div class="form-group">
                                        <label class="font-weight-bold">ORDERING
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="number" class="form-control" name="ordering"
                                            value="{{ old('ordering', $ordering) }}" placeholder="Enter ordering"
                                            required="">
                                        <div class="invalid-feedback alert alert-danger mt-2">
                                            Please fill in the ordering
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- ORDERING -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">STATUS
                                            <span class="text-danger">*</span>
                                        </label>
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
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">EMAIL
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="email"
                                            value="{{ old('email') }}" placeholder="Enter email" required="">
                                        <div class="invalid-feedback alert alert-danger mt-2">
                                            Please fill in the email
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!-- ORDERING -->
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">LOCATION
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="location"
                                            value="{{ old('location') }}" placeholder="Enter location" required="">
                                        <div class="invalid-feedback alert alert-danger mt-2">
                                            Please fill in the location
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label class="font-weight-bold">PHONE
                                            <span class="text-danger">*</span>
                                        </label>
                                        <input type="text" class="form-control" name="phone"
                                            value="{{ old('phone') }}" placeholder="Enter phone" required="">
                                        <div class="invalid-feedback alert alert-danger mt-2">
                                            Please fill in the phone
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <!-- DESCRIPTION -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="font-weight-bold">DESCRIPTION
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea id="summernote" class="summernote-simple form-control" form="fmabt" name="desc" rows="5"
                                            required="">{{ old('desc') }}</textarea>
                                        <div class="invalid-feedback alert alert-danger mt-2">
                                            Please fill in the description
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
        $(document).ready(function() {
            $('#image-upload').change(function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview').attr('src', e.target.result).show();
                    $('#image-label').text(file.name);
                };

                reader.readAsDataURL(file);
            });

            $(document).ready(function() {
                $('#image-upload2').change(function() {
                    var file = this.files[0];
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#preview2').attr('src', e.target.result).show();
                        $('#image-label2').text(file.name);
                    };

                    reader.readAsDataURL(file);
                });
            });

            $(document).ready(function() {
                $('#image-upload3').change(function() {
                    var file = this.files[0];
                    var reader = new FileReader();

                    reader.onload = function(e) {
                        $('#preview3').attr('src', e.target.result).show();
                        $('#image-label3').text(file.name);
                    };

                    reader.readAsDataURL(file);
                });
            });

            $('#image-banner').change(function() {
                var file = this.files[0];
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#preview2').attr('src', e.target.result).show();
                    $('#image-label2').text(file.name);
                };

                reader.readAsDataURL(file);
            });
        });
    </script>
@endsection
