@extends('layout.dashboard.app', ['title' => 'Edit About'])

@section('content')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'about.edit')
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
                        <a href="{{ route('about.index') }}" class="btn btn-warning" data-toggle="tooltip"
                           title="Back"><i class="fas fa-backward"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="fmlabel-edit" action="{{ route('about.update', $data->id) }}" method="POST"
                          enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- ICON -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">ICON</label>
                                    <select class="form-control" name="icon" required="">
                                        <option value="cycling" {{ $data->icon == 'cycling' ? 'selected' :
                                            '' }}>
                                            Bicycle
                                        </option>
                                        <option value="building-house" {{ $data->icon == 'building-house' ? 'selected' :
                                            '' }}>
                                            Building
                                        </option>
                                        <option value="wallet" {{ $data->icon == 'wallet' ? 'selected' : '' }}>
                                            Wallet
                                        </option>
                                        <option value="window-alt" {{ $data->icon == 'window-alt' ? 'selected' : '' }}>
                                            Window
                                        </option>
                                        <option value="tachometer" {{ $data->icon == 'tachometer' ? 'selected' : '' }}>
                                            Tachometer
                                        </option>
                                        <option value="trophy" {{ $data->icon == 'trophy' ? 'selected' : '' }}>
                                            Trophy
                                        </option>
                                    </select>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the icon
                                    </div>
                                </div>
                            </div>
                            <!-- TITLE -->
                            <div class="col-8">
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
                                    <textarea class="summernote-simple form-control" form="fmlabel-edit" name="desc"
                                              rows="5" required="">{!! $data->desc !!}</textarea>
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
                                           value="{{ $data->ordering }}" placeholder="Enter ordering" required="">
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

@endsection
