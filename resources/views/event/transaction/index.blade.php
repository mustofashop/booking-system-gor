@extends('layout.dashboard.app', ['title' => 'List Event'])

@section('content')
<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'event')
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
                        <a href="{{ route('event.create') }}" class="btn btn-success" data-toggle="tooltip"
                           title="Tambah"><i class="fas fa-plus-circle"></i></a>
                        &nbsp;
                        <a class="btn btn-warning" href="{{ route('event.calendar') }}"
                           data-toggle="tooltip" title="Calendar"><i class="fas fa-calendar"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr style="text-align:left">
                                <th colspan="3">EVENT</th>
                                <th colspan="2">INFO</th>
                                <th style="text-align:center">ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td class="text-center">
                                    @if ($item->image && Storage::exists('public/event/' . $item->image))
                                    <img src="{{ asset('storage/event/' . $item->image) }}" class="img-thumbnail"
                                         width="200">
                                    @else
                                    <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail"
                                         width="100">
                                    @endif
                                    <div class="col-md-12">
                                    @if ($item->photo_circuit && Storage::exists('public/event/' . $item->photo_circuit))
                                    <img src="{{ asset('storage/event/' . $item->photo_circuit) }}" class="img-thumbnail"
                                         width="200">
                                    @else
                                    <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail"
                                         width="100">
                                    @endif
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="row justify-content-md-center m-3">
                                        <div class="col-md-12">
                                            <h5>{{ $item->title }}</h5>
                                        </div>
                                        <div class="col-md-12">
                                            <p> #{{ $item->code }} </p> / <b> {{ $item->organizer }} </b>
                                        </div>
                                        <div class="col-md-12">
                                            <p>{{ strlen($item->description) > 80 ? substr($item->description, 0, 80) .
                                                '...' : $item->description }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <h2 style="color: #026b3c"> {{ "Rp " . number_format($item->price, 2, ',',
                                                '.') }} </h2>
                                        </div>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <p>{{ $item->location }}</p>
                                            <p>{{ $item->gate }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <p>{{ date('d F Y', strtotime($item->date)) }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <p> {{ $item->time }} </p>
                                        </div>
                                        <div class="badge badge-dark" title="Quota">
                                            {{ $item->count_limit }}
                                        </div>
                                        <div class="badge badge-{{ $item->status == 'ACTIVE' ? 'success' : 'danger' }}">
                                            {{ $item->status }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row justify-content-md-center m-1">
                                        <div class="col-md-4">
                                            <a href="{{ route('event.edit', $item->id) }}"
                                               class="btn btn-warning btn-action m-1" data-toggle="tooltip"
                                               title="Edit">
                                                <i class="fas fa-pencil-alt m-1"></i></a>
                                        </div>
                                        <div class="col-md-4">
                                            <a href="javascript:void(0)" id="show-user" data-target="#userShowModal"
                                               data-url="{{ route('event.show', $item->id) }}"
                                               class="btn btn-primary btn-action m-1"
                                               title="Show"><i class="fas fa-eye m-1"></i>
                                            </a>
                                        </div>
                                        <div class="col-md-4">
                                            <a class="btn btn-danger btn-action m-1"
                                               onclick="deleteConfirmation('{{$item->id}}', '{{ $item->code }}')"
                                               data-toggle="tooltip" title="Delete"><i class="fas fa-trash m-1"></i>
                                            </a>
                                        </div>
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

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript">
        function deleteConfirmation(id, code) {
            swal({
                title: "Are you sure you want to delete data " + code + " ?",
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
                        url: "{{url('/event/destroy')}}/" + id,
                        data: {
                            _token: CSRF_TOKEN,
                            _method: 'DELETE',
                            id: id
                        },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal("Success", results.message, "success");
                                window.location.replace("{{ url('event') }}");
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

        // Code to load image when editing
        var imageUrl = '{{ isset($data->image) ? asset("storage/event/" . $data->image) : "" }}';
        if (imageUrl) {
            $('#preview').attr('src', imageUrl).show();
            $('#image-label').text('Change File');
        }

        /* When click show user */
        $('body').on('click', '#show-user', function () {
            var userURL = $(this).data('url');
            $.get(userURL, function (data) {
                $('#userShowModal').modal('show');
                $('#code').text(data.code);
                $('#title').text(data.title);
                $('#description').text(data.description);
                $('#date').text(data.date);
                $('#time').text(data.time);
                $('#location').text(data.location);
                $('#maps').text(data.maps);
                $('#organizer').text(data.organizer);
                $('#start_date').text(data.start_date);
                $('#end_date').text(data.end_date);
                $('#expiry_date').text(data.expiry_date);
            })
        });

    </script>
</section>
@endsection

<!-- MODAL -->
<div class="modal fade" id="userShowModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Show User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body table-responsive">
                <table class="table table-bordered no-margin">
                    <tbody>
                    <tr>
                        <td><strong>IMAGE</strong></td>
                        <td>
                            <img src="{{ asset('storage/event/' . $item->image) }}">
                        </td>
                    </tr>
                    <tr>
                        <td><strong>CODE</strong></td>
                        <td id="code"></td>
                    </tr>
                    <tr>
                        <td><strong>TITLE</strong></td>
                        <td id="title"></td>
                    </tr>
                    <tr>
                        <td><strong>DESCRIPTION</strong></td>
                        <td id="description"></td>
                    </tr>
                    <tr>
                        <td><strong>DATE</strong></td>
                        <td id="date"></td>
                    </tr>
                    <tr>
                        <td><strong>TIME</strong></td>
                        <td id="time"></td>
                    </tr>
                    <tr>
                        <td><strong>LOCATION</strong></td>
                        <td id="location"></td>
                    </tr>
                    <tr>
                        <td><strong>MAPS</strong></td>
                        <td id="maps"></td>
                    </tr>
                    <tr>
                        <td><strong>ORGANIZER</strong></td>
                        <td id="organizer"></td>
                    </tr>
                    <tr>
                        <td><strong>START DATE</strong></td>
                        <td id="start_date"></td>
                    </tr>
                    <tr>
                        <td><strong>END DATE</strong></td>
                        <td id="end_date"></td>
                    </tr>
                    <tr>
                        <td><strong>EXPIRY DATE</strong></td>
                        <td id="expiry_date"></td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

