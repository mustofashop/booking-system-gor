@extends('layout.dashboard.app', ['title' => 'List Article'])

@section('content')
<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'article')
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
                        <a href="{{ route('article.create') }}" class="btn btn-success" data-toggle="tooltip"
                           title="Add"><i class="fas fa-plus-circle"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr style="text-align:left">
                                <th>IMAGE</th>
                                <th>DESCRIPTION</th>
                                <th>INFO</th>
                                <th>ORDERING</th>
                                <th>STATUS</th>
                                <th style="text-align:center">ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td style="text-align: left;">
                                    @if ($item->image && Storage::exists('public/news/' . $item->image))
                                    <img src="{{ url('storage/news/' . $item->image) }}" class="img-thumbnail"
                                         width="100">
                                    @else
                                    <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail"
                                         width="100">
                                    @endif
                                </td>
                                <td>
                                    {{ $item->title }}
                                    {!! Str::words(html_entity_decode($item->desc), 50, ' ...') !!}
                                </td>
                                <td>
                                    @if (!$item->location && !$item->email && !$item->phone)
                                    @else
                                    <i class="fas fa-map-marker-alt"></i> {{ $item->location }}
                                    <br>
                                    <i class="fa fa-envelope"></i> {{ $item->email }}
                                    <br>
                                    <i class="fas fa-phone"></i> {{ $item->phone }}
                                    @endif
                                </td>
                                <td>
                                    {{ $item->ordering }}
                                </td>
                                <td>
                                    <div class="badge badge-{{ $item->status == 'ACTIVE' ? 'success' : 'danger' }}">
                                        {{ $item->status }}
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="row justify-content-md-center">
                                        <a href="{{ route('article.edit', $item->id) }}"
                                           class="btn btn-warning btn-action m-1" data-toggle="tooltip" title="Edit"><i
                                                class="fas fa-pencil-alt"></i></a>
                                        <button class="btn btn-danger m-1"
                                                onclick="deleteConfirmation('{{ $item->id }}', '{{ $item->title }}')"
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
        function deleteConfirmation(id, title) {
            swal({
                title: "Are you sure you want to delete data " + title + " ?",
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
                        url: "{{ url('/article/destroy') }}" + '/' + id,
                        data: {
                            _token: CSRF_TOKEN,
                            _method: 'DELETE',
                            id: id
                        },
                        dataType: 'JSON',
                        success: function (results) {
                            if (results.success === true) {
                                swal("Success", results.message, "success");
                                window.location.replace("{{ url('article') }}");
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
