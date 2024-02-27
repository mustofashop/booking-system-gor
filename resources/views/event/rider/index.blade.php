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
                                <th>CODE</th>
                                <th>NAME</th>
                                <th>NICKNAME</th>
                                <th>PLACE</th>
                                <th>DATE</th>
                                <th>GENDER</th>
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
                                <td>
                                    {{ $item->code }}
                                </td>
                                <td>
                                    {{ $item->name }}
                                </td>
                                <td>
                                    {{ $item->nickname }}
                                </td>
                                <td>
                                    {{ $item->place }}
                                </td>
                                <td>
                                    {{ $item->gender }}
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
                                        <a href="{{ route('member.show', $item->id) }}"
                                            class="btn btn-primary btn-action" data-toggle="tooltip" title="Show"><i
                                            class="fas fa-eye"></i></a>
                                        &nbsp;
                                        <button class="btn btn-danger" onclick="deleteConfirmation('{{$item->id}}')"
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
        function deleteConfirmation(id) {
            swal({
                title: "Are you sure you delete data ?",
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
                            "id": id
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
    </script>

</section>
@endsection
