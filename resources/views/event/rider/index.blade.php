@extends('layout.dashboard.app', ['title' => 'List Rider'])

@section('content')
<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'member')
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
                        <a href="{{ route('member.create') }}" class="btn btn-success" data-toggle="tooltip"
                           title="Tambah"><i class="fas fa-plus-circle"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr style="text-align:left">
                                <th>IMAGE</th>
                                <th colspan="2">RIDER</th>
                                {{-- <th>NAME</th> --}}
                                {{-- <th>NICKNAME</th> --}}
                                {{-- <th>PLACE</th> --}}
                                <th>DATE</th>
                                {{-- <th>GENDER</th> --}}
                                <th>STATUS</th>
                                <th style="text-align:center">ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td class="text-center">
                                    @if ($item->image && Storage::exists('public/rider/' . $item->image))
                                    <img src="{{ asset('storage/rider/' . $item->image) }}" class="img-thumbnail"
                                         width="100">
                                    @else
                                    <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail"
                                         width="100">
                                    @endif
                                </td>
                                <td colspan="2">
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <P> {{ $item->code }} </P>
                                        </div>
                                        <div class="col-md-12">
                                            <P> {{ $item->name }} </P>
                                        </div>
                                        <div class="col-md-12">
                                            <P> {{ $item->place }} </P>
                                        </div>
                                        <div class="col-md-12">
                                            <P> {{ $item->gender }} </P>
                                        </div>
                                    </div>
                                </td>
                                {{-- <td>
                                    {{ $item->nickname }}
                                </td> --}}
                                <td>
                                    {{ date('d F Y', strtotime($item->date)) }}
                                </td>
                                <td>
                                    <div class="badge badge-{{ $item->status == 'ACTIVE' ? 'success' : 'danger' }}">
                                        {{ $item->status }}
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="row justify-content-md-center">
                                        <a href="{{ route('member.edit', $item->id) }}"
                                           class="btn btn-warning btn-action" data-toggle="tooltip" title="Edit"><i
                                                class="fas fa-pencil-alt"></i></a>
                                        &nbsp;
                                        {{-- <a href="{{ route('member.show', $item->id) }}"
                                            class="btn btn-primary btn-action" data-toggle="tooltip" title="Show"><i
                                            class="fas fa-eye"></i></a> --}}
                                        <a
                                        href="javascript:void(0)"
                                        id="show-user" data-target="#userShowModal"
                                        data-url="{{ route('member.show', $item->id) }}" class="btn btn-primary btn-action"
                                        title="Show"><i class="fas fa-eye"></i></a>
                                        &nbsp;
                                        <button class="btn btn-danger" onclick="deleteConfirmation('{{$item->id}}', '{{ $item->code }}')"
                                                data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i>
                                        </button>
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
        function deleteConfirmation(id, code) {
            swal({
                title: "Are you sure you want to delete data " + code + " ?",
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
                        url: "{{url('/member/destroy')}}/" + id,
                        data: {
                            _token: CSRF_TOKEN,
                            _method: 'DELETE',
                            id: id
                        },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal("Success", results.message, "success");
                                window.location.replace("{{ url('member') }}");
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
            $('#name').text(data.name);
            $('#nickname').text(data.nickname);
            $('#place').text(data.place);
            $('#date').text(data.date);
            $('#gender').text(data.gender);
            $('#status').text(data.status);
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
                                <img src="{{ asset('storage/member/' . $item->image) }}">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>CODE</strong></td>
                            <td id="code"></td>
                        </tr>
                        <tr>
                            <td><strong>NAME</strong></td>
                            <td id="name"></td>
                        </tr>
                        <tr>
                            <td><strong>GENDER</strong></td>
                            <td id="gender"></td>
                        </tr>
                        <tr>
                            <td><strong>NICKNAME</strong></td>
                            <td id="nickname"></td>
                        </tr>
                        <tr>
                            <td><strong>DATE</strong></td>
                            <td id="date"></td>
                        </tr>
                        <tr>
                            <td><strong>STATUS</strong></td>
                            <td id="status"></td>
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
