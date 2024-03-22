@extends('layout.dashboard.app', ['title' => 'Create Nationality'])

@section('content')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'nationality.edit')
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
                        <a href="{{ route('nationality.index') }}" class="btn btn-warning" data-toggle="tooltip"
                           title="Back"><i class="fas fa-backward"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="fm-artc" action="{{ route('nationality.update', $data->id) }}" method="POST"
                        enctype="multipart/form-data" class="needs-validation" novalidate="">
                      @csrf
                      @method('PUT')
                        <div class="row">
                            <!-- NAME -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">NAME</label>
                                    <input type="text" class="form-control" name="name"
                                        value="{{ old('name', $data->name) }}"
                                           placeholder="Enter name" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the name
                                    </div>
                                </div>
                            </div>
                            <!-- CODE -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">CODE</label>
                                    <input type="text" class="form-control" name="code"
                                        value="{{ old('code', $data->code) }}"
                                            placeholder="Enter code" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the code
                                    </div>
                                </div>
                            </div>
                        </div>
                            <!-- STATUS -->
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">STATUS</label>
                                    <select class="form-control select2" name="status"
                                            value="{{ old('status') }}"
                                            placeholder="Pilih status" required="">
                                        <option value="">-- Choose --</option>
                                        <option value="ACTIVE" {{ old(
                                            'status', $data->status) == 'ACTIVE' ? 'selected' : ''
                                            }}>ACTIVE</option>
                                        <option value="INACTIVE" {{ old(
                                            'status', $data->status) == 'INACTIVE' ? 'selected' : ''
                                            }}>INACTIVE</option>
                                    </select>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the status
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
