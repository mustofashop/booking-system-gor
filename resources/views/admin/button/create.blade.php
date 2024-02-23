@extends('layout.dashboard.app', ['title' => 'Create Button'])

@section('content')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'button.create')
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
                        <a href="{{ route('button.index') }}" class="btn btn-warning" data-toggle="tooltip"
                           title="Back"><i class="fas fa-backward"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="fmlabel" action="{{ route('button.store') }}" method="POST"
                          enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        <div class="row">
                            <!-- CODE -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">CODE</label>
                                    <input type="text" class="form-control" name="code" value="{{ old('code') }}"
                                           placeholder="Enter code" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the code
                                    </div>
                                </div>
                            </div>
                            <!-- TITLE -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">TITLE</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                                           placeholder="Enter title" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the title
                                    </div>
                                </div>
                            </div>
                            <!-- URL -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">URL</label>
                                    <input type="number" class="form-control" name="url"
                                           value="{{ old('url') }}"
                                           placeholder="Enter url # or javascript:void(0)" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the url # or javascript:void(0)
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
