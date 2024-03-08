@extends('layout.dashboard.app', ['title' => 'Edit Point'])

@section('content')

{{-- Alert Messages --}}
@include('layout.dashboard.partials.alert')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'point.edit')
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
                        <a href="{{ route('point.index') }}" class="btn btn-warning" data-toggle="tooltip"
                           title="Back"><i class="fas fa-backward"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="fmuser-edit" action="{{ route('point.update', $data->id) }}" method="POST"
                        enctype="multipart/form-data" class="needs-validation" novalidate="">
                      @csrf
                      @method('PUT')
                        <div class="row">
                            <!-- MEMBER -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">MEMBER</label>
                                    <select class="form-control select2" name="member_id" value="{{ old('member_id', $data->member_id) }}"
                                            placeholder="Pilih MEMBER" required="">
                                        <option value="">-- Choose --</option>
                                        @forelse ($member as $item)
                                        <option value="{{$item->id}}" {{ $item->id == $data->member_id ? 'selected': '' }} >{{$item->name}} | {{$item->place}} | {{$item->email}} </option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the gender
                                    </div>
                                </div>
                            </div>
                            <!-- EVENT -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">EVENT</label>
                                    <select class="form-control select2" name="event_id" value="{{ old('event_id', $data->event_id) }}"
                                            placeholder="Pilih EVENT" required="">
                                        <option value="">-- Choose --</option>
                                        @forelse ($event as $item)
                                        <option value="{{$item->id}}" {{ $item->id == $data->event_id ? 'selected': '' }} >{{$item->code}} | {{$item->title}}</option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the gender
                                    </div>
                                </div>
                            </div>
                            <!-- CATEGORY -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">CATEGORY</label>
                                    <select class="form-control select2" name="category_id" value="{{ old('category_id', $data->category_id) }}"
                                            placeholder="Pilih EVENT" required="">
                                        <option value="">-- Choose --</option>
                                        @forelse ($event_cat as $item)
                                        <option value="{{$item->id}}" {{ $item->id == $data->category_id ? 'selected': '' }} >{{$item->title}} | {{$item->description}} </option>
                                        @empty
                                        @endforelse
                                    </select>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the gender
                                    </div>
                                </div>
                            </div>
                            <!-- STATUS -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">STATUS</label>
                                    <select class="form-control select2" name="status" value="{{ old('status', $data->status) }}"
                                            placeholder="Pilih status" required="">
                                        <option value="">-- Choose --</option>
                                        <option value="ACTIVE" {{ $data->status == 'ACTIVE' ? 'selected' : '' }} >ACTIVE</option>
                                        <option value="INACTIVE" {{ $data->status == 'INACTIVE' ? 'selected' : ''
                                        }} >INACTIVE</option>
                                    </select>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the status
                                    </div>
                                </div>
                            </div>
                            <!-- POINT PARTICIPATION -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">POINT PARTICIPATION</label>
                                    <input type="number" class="form-control" name="point_participation"
                                    value="{{ old('point_participation', $data->point_participation) }}"
                                           placeholder="Enter point participation" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the point participation
                                    </div>
                                </div>
                            </div>
                            <!-- TOTAL POINT -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">TOTAL POINT</label>
                                    <input type="number" class="form-control" name="total_point"
                                    value="{{ old('total_point', $data->total_point) }}"
                                           placeholder="Enter confirm total point" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the confirm total point
                                    </div>
                                </div>
                            </div>
                            <!-- RANK -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">RANK</label>
                                    <input type="number" class="form-control" name="rank"
                                    value="{{ old('rank', $data->rank) }}"
                                           placeholder="Enter confirm total rank" readonly="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the confirm total rank
                                    </div>
                                </div>
                            </div>
                            <!-- POINT RANK -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">POINT RANK</label>
                                    <input type="number" class="form-control" name="point_rank" value="{{ old('point_rank', $data->point_rank) }}"
                                           placeholder="Enter point rank" readonly="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the point rank
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
