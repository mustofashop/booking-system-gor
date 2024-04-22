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
            <div class="card-body">
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                    <div class="col-lg-12 mt-4 mt-lg-0">
                        <form action="{{ route('event.index') }}" method="GET">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Search Event" name="search"
                                       value="{{ request()->get('search') }}">
                                <select class="form-control" name="month">
                                    <option value="">Select Month</option>
                                    <option value="01">January</option>
                                    <option value="02">February</option>
                                    <option value="03">March</option>
                                    <option value="04">April</option>
                                    <option value="05">May</option>
                                    <option value="06">June</option>
                                    <option value="07">July</option>
                                    <option value="08">August</option>
                                    <option value="09">September</option>
                                    <option value="10">October</option>
                                    <option value="11">November</option>
                                    <option value="12">December</option>
                                </select>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="submit">Search</button>
                                </div>
                            </div>
                        </form>
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
                                    <img src="{{ asset('storage/event/' . $item->image) }}" class="img-thumbnail">
                                    @else
                                    <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail">
                                    @endif
                                </td>
                                <td colspan="2">
                                    <div class="row justify-content-md-center m-3">
                                        <div class="col-md-12">
                                            <h5>{{ $item->title }}</h5>
                                        </div>
                                        <div class="col-md-12">
                                            <p> #{{ $item->code }} </p> <b> {{ $item->organizer }} </b>
                                        </div>
                                        <div class="col-md-12">
                                            <p>{{ strlen($item->description) > 80 ? substr($item->description, 0, 80) .
                                                '...' : $item->description }}</p>
                                            <!--                                         <p> <i class="fas fa-money-bill-wave" style="font-size: 24px;"></i> -->
                                            <!--                                            {{ "Rp " . number_format($item->cost, 2, ',','.') }}</p>-->
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
                                            <p><i class="fas fa-map-marker-alt"></i> {{ $item->location }}</p>
                                            <p><i class="fas fa-flag"></i> {{ $item->gate }}</p>
                                        </div>
                                        <div class="col-md-12">
                                            <p>
                                                <i class="fas fa-calendar-alt"></i> {{ date('d F Y',
                                                strtotime($item->date)) }}
                                            </p>
                                        </div>
                                        <div class="col-md-12">
                                            <p>
                                                <i class="fas fa-clock"></i> {{ date('H:i', strtotime($item->time)) }}
                                            </p>
                                        </div>
                                        <div class="badge badge-info" title="Circuit">
                                            <a href="javascript:void(0)" id="show-circuit"
                                               data-target="#circuitShowModal"
                                               data-url="{{ route('event.circuit', $item->id) }}"
                                               title="Circuit"><i class="fas fa-road"></i>
                                            </a>
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
                                        &nbsp;
                                        <div class="col-md-4">
                                            <a href="javascript:void(0)" id="show-user" data-target="#userShowModal"
                                               data-url="{{ route('event.show', $item->id) }}"
                                               class="btn btn-primary btn-action m-1"
                                               title="Show"><i class="fas fa-eye m-1"></i>
                                            </a>
                                        </div>
                                        &nbsp;
                                        {{-- <div class="col-md-4">
                                            <a href="javascript:void(0)" id="showUserDetails" data-target="#userModal"
                                                data-url="{{ route('event.detail-member', $item->id) }}"
                                                class="btn btn-success btn-action m-1"
                                                title="Show"><i class="fas fa-list-alt"></i>
                                            </a>
                                        </div> --}}
                                        <div class="col-md-4">
                                            <a href="{{ route('event.detail-member', $item->id) }}"
                                               class="btn btn-success btn-action m-1" data-toggle="tooltip"
                                               title="Detail Event"><i class="fas fa-list-alt"></i>
                                            </a>
                                        </div>
                                        &nbsp;
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
                            <div class="col-md-12">
                                <div class="alert alert-danger" role="alert">
                                    No Data Found
                                </div>
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
            // var imageUrl = $(this).data('image');
            $.get(userURL, function (data) {
                $('#userShowModal').modal('show');
                $('#image').attr('src', '{{ asset('storage/event/') }}' + '/' + data.image);
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

        /* When click show user detail */
        $('body').on('click', '#showUserDetails', function () {
            var userURL = $(this).data('url');
            // var imageUrl = $(this).data('image');
            $.get(userURL, function (items) {
                $('#userModal').modal('show');
                $('#code').text(items.code);
            })
        });

        /* When click show circuit */
        $('body').on('click', '#show-circuit', function () {
            var userURL = $(this).data('url');
            $.get(userURL, function (data) {
                $('#circuitShowModal').modal('show');
                // Assuming data contains both the image URL and circuit information
                $('#circuit').html(data.info_circuit); // Display circuit information

                // Generate the URL for the image using Laravel's asset helper
                var imageUrl = '{{ asset("storage/event/") }}' + '/' + data.photo_circuit;

                // Check if the image exists
                $.get(imageUrl)
                    .done(function () {
                        // Image exists, display it
                        $('#circuit-image').html('<img src="' + imageUrl + '" alt="Circuit Image" class="img-thumbnail">');
                    })
                    .fail(function () {
                        // Image doesn't exist, display default image
                        var defaultImageUrl = '{{ asset("assets/img/default-image.jpg") }}'; // Path to default image
                        $('#circuit-image').html('<img src="' + defaultImageUrl + '" alt="Default Image" class="img-thumbnail">');
                    });
            });
        });
    </script>
</section>
@endsection

<!-- Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Detail Pengguna</h5>
            </div>
                <!-- Tabel di dalam modal untuk menampilkan detail pengguna -->
                <table id="modalBody">
                    <thead>
                        <tr>
                        <th>CODE</th>
                        <th>Usia</th>
                        <th>Alamat</th>
                      </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td id="code"></td>
                        <td>30</td>
                        <td>Jl. Contoh No. 123</td>
                      </tr>
                      <!-- Anda bisa menambahkan baris-baris data lain di sini -->
                    </tbody>
                  </table>
                <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- MODAL CIRCUIT -->
<div class="modal fade" id="circuitShowModal" tabindex="-1" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Show Circuit</h5>
            </div>
            <div class="modal-body">
                <div id="circuit-image"></div> <!-- Container for the circuit image -->
                <div id="circuit"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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
                            <img src="" id="image" class="img-thumbnail" style="width: 100px; height: 100px;">
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