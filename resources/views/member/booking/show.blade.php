@extends('layout.dashboard.app', ['title' => 'Reservation Cart'])

@section('content')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'booking.create')
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
                        <a href="{{ route('booking.index') }}" class="btn btn-warning" data-toggle="tooltip"
                           title="Back"><i class="fas fa-backward"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="fmlabel" action="{{ route('booking.bucket', $data->id) }}" method="post"
                          enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        <div class="row">
                            <!-- IMAGE -->
                            <div class="col-4">
                                <div id="image-preview" class="image-preview">
                                    @if ($data->image && Storage::exists('public/event/' . $data->image))
                                    <img src="{{ asset('storage/event/' . $data->image) }}" class="img-thumbnail">
                                    @else
                                    <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail">
                                    @endif
                                </div>
                            </div>
                            <!-- CODE -->
                            <div class="col-8">
                                <div class="row">
                                    <div class="form-group col-4">
                                        <input type="hidden" name="event_id" value="{{ $data->id }}">
                                        <h6 class="font-weight-bold">{{ $data->code }}</h6>
                                        <h3>{{ $data->title }}</h3>
                                        <i class="fas fa-calendar-alt"></i> {{ date('d F Y', strtotime($data->date)) }}
                                        <i class="fas fa-clock"></i> {{ date('H:i', strtotime($data->time)) }}
                                        <i class="fas fa-map-marker-alt"></i> {{ $data->location }}
                                        <br>
                                        <i class="fas fa-building"></i> {{ $data->organizer }}
                                        <br>
                                        <h3>Rp. {{ number_format($data->price, 0, ',', '.') }}</h3>
                                        <a href="{{ $data->maps }}" target="_blank" class="mb-3">{{ $data->maps }}
                                        </a>
                                        <br>
                                        <br>
                                        <div
                                            class="badge badge-{{ $data->status == 'ACTIVE' ? 'success' : 'danger' }}">
                                            @if($data->status == 'ACTIVE')
                                            <span>OPEN</span>
                                            @elseif($data->status == 'INACTIVE')
                                            <span>CLOSE</span>
                                            @else
                                            {{ $data->status }}
                                            @endif
                                        </div>
                                        <span class="badge badge-dark">{{ $quota }} / {{ $data->count_limit }}</span>
                                    </div>
                                    <div class="form-group col-8">
                                        <table class="table table-borderless">
                                            <tbody>
                                            <tr>
                                                <td>
                                                    @foreach ($label as $item)
                                                    @if ($item->code == 'event.open')
                                                    <b title="{!!html_entity_decode($item->desc)!!}">{!!html_entity_decode($item->title)!!}</b>
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>:</td>
                                                <td>{{ date('d F Y H:i', strtotime($data->start_date)) }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    @foreach ($label as $item)
                                                    @if ($item->code == 'event.close')
                                                    <b title="{!!html_entity_decode($item->desc)!!}">{!!html_entity_decode($item->title)!!}</b>
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>:</td>
                                                <td>{{ date('d F Y H:i', strtotime($data->end_date)) }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    @foreach ($label as $item)
                                                    @if ($item->code == 'event.expired')
                                                    <b title="{!!html_entity_decode($item->desc)!!}">{!!html_entity_decode($item->title)!!}</b>
                                                    @endif
                                                    @endforeach
                                                </td>
                                                <td>:</td>
                                                <td>{{ date('d F Y H:i', strtotime($data->expiry_date)) }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        {{ old('description', html_entity_decode($data->description)) }}
                                    </div>
                                </div>
                            </div>
                            <hr class="m-3" style="width:100%;text-align:left;margin-left:0; color:black">
                            <!-- DATE -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">DATE</label>
                                    <input type="date" class="form-control" name="date" value="{{ old('date') }}"
                                           placeholder="Enter date" required min="{{ date('Y-m-d') }}">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the date
                                    </div>
                                </div>
                            </div>
                            <!-- CATEGORY -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">CATEGORY</label>
                                    <select class="form-control select2" name="category" value="{{ old('category') }}"
                                            placeholder="Choose category" required="">
                                        <option value="">-- Choose --</option>
                                        <option value="RESERVATION">RESERVATION</option>
                                        <!--                                        <option value="MODIFICATION">MODIFICATION</option>-->
                                        <!--                                        <option value="CANCELLATION">CANCELLATION</option>-->
                                    </select>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the status
                                    </div>
                                </div>
                            </div>
                            <!-- NOTE -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">NOTE</label>
                                    <textarea class="form-control" name="note" value="{{ old('note') }}"
                                              placeholder="Enter note" required=""></textarea>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the note
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if ($member != null)
                        <input type="hidden" name="member_id" value="{{ $member->id }}">
                        <!-- BUTTON -->
                        <div class="form-group">
                            <button type="submit" style="width:100px" class="btn btn-danger btn-action"
                                    data-toggle="tooltip" title="Save"><i class="fas fa-save"></i></button>
                            <button type="reset" onclick="myReset()" class="btn btn-dark btn-action"
                                    data-toggle="tooltip" title="Reset"><i class="fas fa-redo-alt"></i></button>
                        </div>
                        @else
                        <div class="alert alert-danger">
                            <strong>Sorry!</strong> You are not a member yet, please setup your profile first.
                            <a class="btn btn-dark" href="/profile">Click</a>
                        </div>
                        @endif
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
</script>
@endsection
