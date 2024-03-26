@extends('layout.dashboard.app', ['title' => 'Create invoice'])

@section('content')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'invoice.edit')
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
                        <a href="{{ route('invoice.index') }}" class="btn btn-warning" data-toggle="tooltip"
                           title="Back"><i class="fas fa-backward"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="fm-artc" action="{{ route('invoice.update', $data->id) }}" method="POST"
                        enctype="multipart/form-data" class="needs-validation" novalidate="">
                      @csrf
                      @method('PUT')
                      <div class="row">
                        <!-- MEMBER -->
                        <div class="col-6">
                            <div class="form-group">
                                <label for="member_id" class="font-weight-bold">CHOOSE MEMBER <span
                                        class="text-danger">*</span></label>
                                <select id="member_id" name="member_id" class="select2 form-control" required="">
                                    <option value="">Choose</option>
                                    @foreach ($member as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $data->member_id ? 'selected': ''
                                    }}>#{{$item->number_booking }} | {{ $item->code }} | {{ $item->name }}
                                    </option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please select a valid member
                                </div>
                            </div>
                        </div>
                        <!-- COST -->
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold">COST</label>
                                <input type="number" class="form-control" name="cost"
                                value="{{ old('cost', $data->cost) }}"
                                       placeholder="Enter cost" required="">
                                <div class="invalid-feedback alert alert-danger mt-2">
                                    Please fill in the cost
                                </div>
                            </div>
                        </div>
                    </div>
                        <!-- STATUS -->
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold">STATUS <span
                                        class="text-danger">*</span></label>
                                <select class="form-control select2" name="status"
                                        value="{{ old('status', $data->status) }}"
                                        placeholder="Pilih status">
                                    <option value="">-- Choose --</option>
                                    <option value="ACTIVE" {{ $data->status == 'ACTIVE' ? 'selected' : ''
                                        }}>ACTIVE
                                    </option>
                                    <option value="INACTIVE" {{ $data->status == 'INACTIVE' ? 'selected' : ''
                                        }}>INACTIVE
                                    </option>
                                </select>
                                <div class="invalid-feedback alert alert-danger mt-2">
                                    Please fill in the status
                                </div>
                            </div>
                        </div>
                        <!-- COST -->
                        <div class="col-6">
                            <div class="form-group">
                                <label class="font-weight-bold">CODE</label>
                                <input type="text" class="form-control" name="code"
                                value="{{ old('code', $data->code) }}"
                                       placeholder="Enter code" readonly="">
                                <div class="invalid-feedback alert alert-danger mt-2">
                                    Please fill in the code
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
