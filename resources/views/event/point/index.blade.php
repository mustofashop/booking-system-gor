
@extends('layout.dashboard.app', ['title' => 'List Point'])

@section('content')
<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'point')
    <div class="section-title">
        <h3>{!! html_entity_decode($item->title) !!}</h3>
    </div>
    <p class="section-lead">
        {!! html_entity_decode($item->desc) !!}
    </p>
    @endif
    @endforeach
<!DOCTYPE html>
<html>
<head>
    {{-- <title>Laravel Ajax Data Fetch Example</title> --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet"> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>List</h4>
                    <div class="card-header-action">
                        <a href="{{ route('point.create') }}" class="btn btn-success" data-toggle="tooltip"
                           title="Tambah"><i class="fas fa-plus-circle"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr style="text-align:left">
                                <th>MEMBER</th>
                                <th>EVENT</th>
                                <th>CATEGORY</th>
                                <th>POINT RANK</th>
                                <th>POINT PARTICIPATION</th>
                                <th>TOTAL POINT</th>
                                <th>RANK</th>
                                <th style="text-align:center">ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td>
                                    {{ $item->member->code }}
                                </td>
                                <td>
                                    {{ $item->event->code }}
                                </td>
                                <td>
                                    {{ $item->category->title }}
                                </td>
                                <td>
                                    {{ $item->point_rank }}
                                </td>
                                <td>
                                    {{ $item->point_participation }}
                                </td>
                                <td>
                                    {{ $item->total_point }}
                                </td>
                                <td>
                                    {{ $item->rank }}
                                </td>
                                <td>
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-4">
                                            <a href="{{ route('point.edit', $item->id) }}"
                                               class="btn btn-warning btn-action" 
                                               data-toggle="tooltip" title="Edit">
                                               <i class="fas fa-pencil-alt"></i></a>
                                        </div>
                                        <div class="col-md-4">
                                            <a
                                            href="javascript:void(0)"
                                            id="show-user" data-target="#userShowModal"
                                            data-url="{{ route('point.show', $item->id) }}" 
                                            class="btn btn-primary btn-action"
                                            data-toggle="tooltip" title="Show">
                                            <i class="fas fa-eye"></i></a>
                                        </div>
                                        <div class="col-md-4">
                                        <button class="btn btn-danger btn-action" onclick="deleteConfirmation('{{$item->id}}'"
                                         data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i>
                                        </a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <div class="alert alert-danger">
                                Data direktori belum Tersedia.
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
                title: "Are you sure you want to delete data  ?",
                text: "Please confirm and then confirm !",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Hapus",
                cancelButtonText: "Batal",
                cancelButtonColor: "#F0E701",
                confirmButtonColor: "#1AA13E",
                reverseButtons: !0
            }).then(function (e) {
                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/point/destroy')}}/" + id,
                        data: {
                            _token: CSRF_TOKEN,
                            _method: 'DELETE',
                            id: id
                        },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal("Success", results.message, "success");
                                window.location.replace("{{ url('point') }}");
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
</body>
</html>

