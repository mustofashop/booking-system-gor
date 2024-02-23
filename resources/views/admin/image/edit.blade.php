@extends('layout.dashboard.app', ['title' => 'Edit Image'])

@section('content')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'image.edit')
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
                        <a href="{{ route('image.index') }}" class="btn btn-warning" data-toggle="tooltip"
                           title="Back"><i class="fas fa-backward"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="fmlabel-edit" action="{{ route('image.update', $data->id) }}" method="POST"
                          enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- IMAGE -->
                            <div class="col-6">
                                <div id="image-preview" class="image-preview"
                                     data-image-url="{{ isset($user->image_url) ? asset('storage/image/' . $user->image_url) : '' }}">
                                    <img id="preview"
                                         src="{{ isset($data->image) ? asset('storage/image/' . $data->image) : '' }}"
                                         alt="Image Preview" style="max-width: 100%; max-height: 200px; display: none;">
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="image" id="image-upload">
                                </div>
                            </div>
                            <!-- CODE -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">CODE</label>
                                    <input type="text" class="form-control" name="code" value="{{ $data->code }}"
                                           placeholder="Enter code" required="" readonly>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the code
                                    </div>
                                </div>
                            </div>
                            <!-- TITLE -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">TITLE</label>
                                    <input type="text" class="form-control" name="title" value="{{ $data->title }}"
                                           placeholder="Enter title" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the title
                                    </div>
                                </div>
                            </div>
                            <!-- DESCRIPTION -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">DESCRIPTION</label>
                                    <textarea class="form-control" name="desc"
                                              placeholder="Enter description" required="">{{ $data->desc }}</textarea>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the description
                                    </div>
                                </div>
                            </div>
                            <!-- ORDERING -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">ORDERING</label>
                                    <input type="number" class="form-control" name="ordering"
                                           value="{{ $data->ordering }}"
                                           placeholder="Enter ordering" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the ordering
                                    </div>
                                </div>
                            </div>
                            <!-- STATUS -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">STATUS</label>
                                    <select class="form-control" name="status" required="">
                                        <option value="ACTIVE" {{ $data->status == 'ACTIVE' ? 'selected' : '' }}>
                                            ACTIVE
                                        </option>
                                        <option value="INACTIVE" {{ $data->status == 'INACTIVE' ? 'selected' : '' }}>
                                            INACTIVE
                                        </option>
                                    </select>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please select the status
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

    // Code to load image when editing
    var imageUrl = '{{ isset($data->image) ? asset("storage/image/" . $data->image) : "" }}';
    if (imageUrl) {
        $('#preview').attr('src', imageUrl).show();
        $('#image-label').text('Change File');
    }
</script>
@endsection
