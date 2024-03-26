@extends('layout.dashboard.app', ['title' => 'List invoice'])

@section('content')
<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'invoice')
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
                        <a href="{{ route('invoice.create') }}" class="btn btn-success" data-toggle="tooltip"
                           title="Add"><i class="fas fa-plus-circle"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr style="text-align:left">
                                <th>COST</th>
                                <th>MEMBER</th>
                                <th>CODE</th>
                                <th>STATUS</th>
                                <th style="text-align:center">ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td style="text-align: left;">
                                    <i class="fas fa-money-bill-wave" style="font-size: 24px;"></i>
                                    <br>
                                    {{ $item->cost }}
                                </td>
                                <td>
                                    <i class="fas fa-user"></i> {{ strtoupper($item->member->name) }} <br>
                                    <i class="fas fa-map-marker-alt"></i> {{ strtoupper($item->member->place) }} ,
                                    {{ date('d F Y', strtotime($item->member->date)) }} <br>
                                    <i class="fas fa-envelope"></i> {{ $item->member->email }} <br>
                                    <i class="fas fa-phone"></i> {{ $item->member->phone }} <br>
                                </td>
                                <td>
                                    <div class="badge badge-dark">{{ $item->code }}</div>
                                </td>
                                <td>
                                    <div class="badge badge-{{ $item->status == 'ACTIVE' ? 'success' : 'danger' }}">
                                        {{ $item->status }}
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="row justify-content-md-center">
                                        <a href="{{ route('invoice.edit', $item->id) }}"
                                           class="btn btn-warning btn-action m-1" data-toggle="tooltip" title="Edit"><i
                                                class="fas fa-pencil-alt"></i></a>
                                        <button class="btn btn-danger m-1"
                                                onclick="deleteConfirmation('{{ $item->id }}', '{{ $item->code }}')"
                                                data-toggle="tooltip" title="Delete"><i class="fas fa-trash"></i>
                                        </button>
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
        function deleteConfirmation(id, code) {
            swal({
                title: "Are you sure you want to delete data " + code + " ?",
                text: "Please confirm to proceed!",
                type: "warning",
                showCancelButton: true,
                confirmButtonText: "Delete",
                cancelButtonText: "Cancel",
                cancelButtonColor: "#F0E701",
                confirmButtonColor: "#1AA13E",
                reverseButtons: true
            }).then(function (e) {
                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    $.ajax({
                        type: 'POST',
                        url: "{{ url('/invoice/destroy') }}" + '/' + id,
                        data: {
                            _token: CSRF_TOKEN,
                            _method: 'DELETE',
                            id: id
                        },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal("Success", results.message, "success");
                                window.location.replace("{{ url('invoice') }}");
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
