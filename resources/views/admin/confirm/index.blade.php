@extends('layout.dashboard.app', ['title' => 'List Payment'])

@section('content')
<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'payment')
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

                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr style="text-align:left">
                                <th>EVENT</th>
                                <th>PAYMENT</th>
                                <th>DESCRIPTION</th>
                                <th>STATUS</th>
                                <th style="text-align:center">ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td>
                                    <h5>{{ $item->booking->event->title }}</h5>
                                    <i class="fas fa-calendar-alt"></i> {{ date('d F Y',
                                    strtotime($item->booking->event->date)) }}
                                    <i class="fas fa-clock"></i> {{ date('H:i', strtotime($item->booking->event->time))
                                    }}
                                    <i class="fas fa-map-marker-alt"></i> {{ $item->booking->event->location }}
                                    <br>
                                    <i class="fas fa-building"></i> {{ $item->booking->event->organizer }}
                                </td>
                                <td>
                                    <div class="mt-3 mb-3">
                                        <div class="badge badge-dark mt-3 mb-3">
                                            {{ $item->code }}
                                        </div>
                                        <br>
                                        <i class="fas fa-money-bill-wave"></i> {{ $item->methode }}
                                        <br>
                                        <i class="fas fa-calendar-alt"></i> {{ date('d F Y', strtotime($item->date)) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="mt-3 mb-3">
                                        <h3>Rp. {{ number_format($item->amount, 0, ',', '.') }}</h3>
                                        {!! Str::words(html_entity_decode($item->description), 80, ' ...') !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="badge badge-{{ $item->category == 'PAID' ? 'success' : 'danger' }}">
                                        {{ $item->category }}
                                    </div>
                                </td>
                                <td colspan="2">
                                    @if ($item->category == 'UNPAID')
                                    <div class="row justify-content-md-center">
                                        <a href="{{ route('confirm.edit', $item->id) }}"
                                           class="btn btn-warning btn-action" data-toggle="tooltip" title="Confirm"><i
                                                class="fas fa-check">
                                            </i>
                                        </a>
                                    </div>
                                    @else
                                    <div class="row justify-content-md-center">
                                        <a href="{{ route('confirm.show', $item->id) }}"
                                           class="btn btn-info btn-action" data-toggle="tooltip" title="Show"><i
                                                class="fas fa-eye">
                                            </i>
                                        </a>
                                    </div>
                                    @endif
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
                        url: "{{url('/image/destroy')}}/" + id,
                        data: {
                            _token: CSRF_TOKEN,
                            "id": id
                        },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal("Success", results.message, "success");
                                window.location.replace("{{ url('payment') }}");
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
