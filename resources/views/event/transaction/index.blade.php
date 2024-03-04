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
    <script>
        $(document).ready(function(){
            $(document).on('click', '#detail', function(){
               var code = $(this).data('code');
               $('#code').text('code');
        });
    });
    </script>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>List</h4>
                    <div class="card-header-action">
                        <a href="{{ route('event.create') }}" class="btn btn-success" data-toggle="tooltip"
                           title="Tambah"><i class="fas fa-plus-circle"></i></a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                            <tr style="text-align:left">
                                <th>IMAGE</th>
                                <th colspan="2">EVENT</th>
                                {{-- <th>DESCRIPTION</th> --}}
                                <th colspan="2">INFO</th>
                                {{-- <th>TIME</th> --}}
                                {{-- <th>PRICE</th> --}}
                                {{-- <th>STATUS</th> --}}
                                <th style="text-align:center">ACTION</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td class="text-center">
                                    @if ($item->image && Storage::exists('public/event/' . $item->image))
                                    <img src="{{ asset('storage/event/' . $item->image) }}" class="img-thumbnail"
                                         width="100">
                                    @else
                                    <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail"
                                         width="100">
                                    @endif
                                </td>
                                <td colspan="2">
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <h5>{{ $item->title }}</h5>
                                        </div>
                                        <div class="col-md-12">
                                            <p>  {{ $item->code }} </p>
                                          </div>
                                        <div class="col-md-12">
                                            <p>{{ strlen($item->description) > 50 ? substr($item->description, 0, 50) . '...' : $item->description }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <p>  {{ "Rp " . number_format($item->price, 2, ',', '.') }} </p>
                                          </div>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-12">
                                            <p>{{ date('d F Y', strtotime($item->date)) }}</p>
                                        </div>
                                        <div class="col-md-12">
                                          <p>  {{ $item->time }} </p>
                                        </div>
                                        <div class="badge badge-{{ $item->status == 'ACTIVE' ? 'success' : 'danger' }}">
                                            {{ $item->status }}
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="row justify-content-md-center">
                                        <div class="col-md-4">
                                            <a href="{{ route('event.edit', $item->id) }}"
                                               class="btn btn-warning btn-action" data-toggle="tooltip" title="Edit">
                                               <i class="fas fa-pencil-alt"></i></a>
                                        </div>
                                        <div class="col-md-4">
                                        <a href="{{ route('event.show', $item->id) }}" class="btn btn-primary btn-action" data-toggle="tooltip"
                                            title="Show"><i class="fas fa-eye"></i></a>
                                        </div>
                                        {{-- <div class="col-md-4">
                                            <a id="productDetailModal" data-toggle="modal" class="btn btn-primary btn-action" href="#dataModal" title="Show">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </div> --}}
                                        <div class="col-md-4">
                                        <a class="btn btn-danger btn-action" onclick="deleteConfirmation('{{$item->id}}', '{{ $item->code }}')"
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

    <!-- MODAL -->

    {{-- <div class="modal fade" id="productDetailModal" tabindex="-1" role="dialog" aria-labelledby="productDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productDetailModalLabel">Product Detail</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p><strong>Name:</strong> <span id="productName"></span></p>
                    <p><strong>Description:</strong> <span id="productDescription"></span></p>
                    <!-- Add more information as needed -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> --}}
   
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
    </script>

</section>
@endsection

