@extends('layout.dashboard.app', ['title' => 'List Booking'])

@section('content')
<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'booking')
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
            <div class="card">
                <div class="card-header">
                    <h4>List</h4>
                    <div class="card-header-action">
                        <a href="{{ route('bucket-2.create') }}" class="btn btn-success" data-toggle="tooltip"
                           title="Add"><i class="fas fa-plus-circle"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr style="text-align:left">
                                <th colspan="2">BOOKING</th>
                                <th>INFO</th>
                                <th>DESCRIPTION</th>
                                <!--                                <th>STATUS</th>-->
                                <th style="text-align:center">ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td>
                                    @if ($item->event->image && Storage::exists('public/event/' . $item->event->image))
                                    <img src="{{ asset('storage/event/' . $item->event->image) }}" class="img-thumbnail"
                                         width="100">
                                    @else
                                    <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail"
                                         width="100">
                                    @endif
                                </td>
                                <td>
                                    <div class="event-info mt-3 mb-3">
                                        <h6>{{ date('d F Y', strtotime($item->date)) }}</h6>
                                        <h3>{{ $item->event->title }}</h3>
                                        <div class="badge badge-dark">{{ $item->code }}</div>
                                        <div
                                            class="badge badge-{{ $item->event->status == 'ACTIVE' ? 'success' : 'danger' }}">
                                            @if($item->event->status == 'ACTIVE')
                                            <span>OPEN</span>
                                            @elseif($item->event->status == 'INACTIVE')
                                            <span>CLOSE</span>
                                            @else
                                            {{ $item->event->status }}
                                            @endif
                                        </div>
                                        <br>
                                        <br>
                                        <i class="fas fa-calendar-alt"></i> {{ date('d F Y',
                                        strtotime($item->event->date)) }}
                                        <i class="fas fa-clock"></i> {{ date('H:i',
                                        strtotime($item->event->time)) }}
                                        <i class="fas fa-map-marker-alt"></i> {{ $item->event->location }}
                                    </div>
                                </td>
                                <td>
                                    <div class="event-info mt-3 mb-3">
                                        <i class="fas fa-building"></i> {{ $item->event->organizer }}
                                        <br>
                                        <p>{!! Str::words(html_entity_decode($item->note), 80, ' ...') !!} </p>
                                        <h3>Rp. {{ number_format($item->event->price, 0, ',', '.') }}</h3>
                                        <a href="{{ $item->event->maps }}" target="_blank" class="mb-3">{{
                                            $item->event->maps }}</a>
                                    </div>
                                </td>
                                <td>
                                    <div class="event-info">
                                        @if($item->member)
                                        <i class="fas fa-user"></i> {{ strtoupper($item->member->name) }} <br>
                                        <i class="fas fa-user-tag"></i> {{ strtoupper($item->member->nickname) }} <br>
                                        <i class="fas fa-map-marker-alt"></i> {{ strtoupper($item->member->place) }} ,
                                        {{ date('d F Y', strtotime($item->member->date)) }} <br>
                                        <i class="fas fa-envelope"></i> {{ $item->member->email }} <br>
                                        <i class="fas fa-phone"></i> {{ $item->member->phone }} <br>
                                        <div
                                            class="badge badge-{{ $item->category == 'RESERVATION' ? 'info' : 'warning' }}">
                                            {{ $item->category }}
                                        </div>
                                        @else
                                        <img src="{{ asset('assets/img/avatar/avatar-5.png') }}"
                                             class="img-thumbnail mt-2 mb-2"
                                             width="100">
                                        <br>
                                        <div class="badge badge-danger">MEMBER NOT REGISTERED</div>
                                        @endif
                                    </div>
                                </td>
                                <!--                                <td>-->
                                <!--                                    <div class="badge badge-{{ $item->status == 'ACTIVE' ? 'success' : 'danger' }}">-->
                                <!--                                        {{ $item->status }}-->
                                <!--                                    </div>-->
                                <!--                                </td>-->
                                <td colspan="2">
                                    <div class="row justify-content-md-center">
                                        <!--                                        <a href="{{ route('booking.edit', $item->id) }}"-->
                                        <!--                                           class="btn btn-warning btn-action m-1" data-toggle="tooltip" title="Edit"><i-->
                                        <!--                                                class="fas fa-pencil-alt"></i></a>-->
                                        <a class="btn btn-primary btn-action m-1"
                                           href="{{ route('bucket.invoice', $item->id) }}"
                                           data-toggle="tooltip" title="Print"><i class="fas fa-print"></i></a>
                                        <!--                                        <button class="btn btn-danger" onclick="deleteConfirmation('{{$item->id}}')"-->
                                        <!--                                                data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i>-->
                                        <!--                                        </button>-->
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <div class="alert alert-dark m-5">
                                Data not found
                            </div>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="d-felx justify-content-center">
                    <div class="card-footer text-right">
                        {{ $data->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function deleteConfirmation(id) {
            swal({
                title: "Are you sure you delete data ?",
                text: "Please confirm and then confirm !",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel",
                cancelButtonColor: "#F0E701",
                confirmButtonColor: "#1AA13E",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/bucket/destroy')}}/" + id,
                        data: {
                            _token: CSRF_TOKEN,
                            "id": id
                        },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal("Success", results.message, "success");
                                window.location.replace("{{ url('bucket') }}");
                            } else {
                                swal("Failed", results.message, "error");
                            }
                        }
                    });
                } else {
                    e.dismiss;
                }
            }, function (dismiss) {
                return false;
            })
        }
    </script>

</section>
@endsection
