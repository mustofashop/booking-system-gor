@extends('layout.dashboard.app', ['title' => 'Information'])

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
            <div class="card border-0 shadow rounded">
                <div class="card-header">
                    <h4>Create</h4>
                    <div class="card-header-action">
                        <a href="{{ route('booking.index') }}" class="btn btn-warning" data-toggle="tooltip"
                           title="Back"><i class="fas fa-backward"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="fmlabel" action="{{ route('booking.store') }}" method="post"
                          enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        <div class="row">
                            <!-- MEMBER ID -->
                            <input type="hidden" name="member_id" value="{{ $member->id }}">
                            <!-- IMAGE -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="image" class="font-weight-bold">IMAGE</label>
                                    <div id="image-preview" class="image-preview">
                                    </div>
                                </div>
                                <!-- PRICE -->
                                <div class="form-group">
                                    <label for="event_id" class="font-weight-bold">EVENT COST</label>
                                    <div class="table-responsive">
                                        <table id="eventTableCost" class="table table-striped mb-0">
                                            <thead>
                                            <tr>
                                                <th>Price</th>
                                                <th>Jasa</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan="3" class="text-center">No data available in table
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- EVENT -->
                            <div class="col-8">
                                <!-- MEMBER ID -->
                                <div class="form-group">
                                    <label for="event_id" class="font-weight-bold">CHOOSE EVENT <span
                                            class="text-danger">*</span></label>
                                    <select id="event_id" name="event_id" class="form-control" required="">
                                        <option value="">Choose</option>
                                        @foreach ($event as $item)
                                        <option value="{{ $item->id }}">{{ $item->code }} | {{ $item->title }} | {{
                                            date('d F Y', strtotime($item->date)) }} | {{ date('H:i',
                                            strtotime($item->time)) }} | {{ $item->location }}
                                        </option>
                                        @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid event
                                    </div>
                                </div>
                                <!-- EVENT INFO -->
                                <div class="form-group">
                                    <label for="event_id" class="font-weight-bold">EVENT INFO</label>
                                    <div class="table-responsive">
                                        <table id="eventTableInfo" class="table table-striped mb-0">
                                            <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Location</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan="3" class="text-center">No data available in table
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <!-- EVENT QUOTA -->
                                <div class="form-group">
                                    <label for="event_id" class="font-weight-bold">EVENT STATUS</label>
                                    <div class="table-responsive">
                                        <table id="eventTableQuota" class="table table-striped mb-0">
                                            <thead>
                                            <tr>
                                                <th>Status</th>
                                                <th>Booked</th>
                                                <th>Available</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan="3" class="text-center">No data available in table
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- EVENT DETAIL -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="event_id" class="font-weight-bold">EVENT DETAIL</label>
                                    <div class="table-responsive">
                                        <table id="eventTable" class="table table-striped mb-0">
                                            <thead>
                                            <tr>
                                                <th>Code</th>
                                                <th>Title</th>
                                                <th>Description</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                                <td colspan="3" class="text-center">No data available in table</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-3" style="width:100%;text-align:left;margin-left:0; color:black">
                            <!-- DATE -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">DATE <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date" value="{{ date('Y-m-d') }}"
                                           placeholder="Enter date" required min="{{ date('Y-m-d') }}"
                                           max="{{ date('Y-m-d') }}">
                                    <div class="invalid-feedback">
                                        Please fill in the date
                                    </div>
                                </div>
                            </div>
                            <!-- CATEGORY -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">CATEGORY <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select2" name="event_category_id"
                                            value="{{ old('event_category_id') }}"
                                            placeholder="Choose category" required="">
                                        <option value="">-- Choose --</option>
                                        @foreach ($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->title }} | {{
                                            $item->description }}
                                            @endforeach
                                    </select>
                                    <div class="invalid-feedback">
                                        Please fill in the category
                                    </div>
                                </div>
                            </div>
                            <!-- STATUS -->
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="font-weight-bold">STATUS <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control select2" name="category" value="{{ old('category') }}"
                                            placeholder="Choose category" required="">
                                        <option value="">-- Choose --</option>
                                        <option value="CONFIRMATION">RESERVATION</option>
                                        <!--                                        <option value="MODIFICATION">MODIFICATION</option>-->
                                        <!--                                        <option value="CANCELLATION">CANCELLATION</option>-->
                                    </select>
                                    <div class="invalid-feedback">
                                        Please fill in the status
                                    </div>
                                </div>
                            </div>
                            <!-- NOTE -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">NOTE <span
                                            class="text-danger">*</span></label>
                                    <textarea class="form-control" name="note" value="{{ old('note') }}"
                                              placeholder="Enter note" required=""></textarea>
                                    <div class="invalid-feedback">
                                        Please fill in the note
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- BUTTON -->
                        <div class="form-group">
                            <button type="submit" style="width:100px" class="btn btn-danger btn-action"
                                    data-toggle="tooltip" title="Save"><i class="fas fa-save"></i></button>
                            <button type="reset" onclick="myReset()" class="btn btn-dark btn-action"
                                    data-toggle="tooltip" title="Reset"><i class="fas fa-redo-alt"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    document.getElementById('event_id').addEventListener('change', function () {
        var eventId = this.value;

        // Kirim permintaan GET menggunakan fetch
        fetch('/getEventById/' + eventId)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to get event');
                }
                return response.json();
            })
            .then(data => {
                // Tampilkan data event
                if (data) {
                    const event = data.event;
                    const quota = data.quota;

                    // Tampilkan gambar event
                    var imagePreview = document.getElementById('image-preview');
                    var imageHtml = '';

                    // Periksa apakah properti 'image' ada dalam objek 'event'
                    if (event.image && event.image != '') {
                        // Jika 'image' ada, tampilkan gambar event
                        imageHtml = `<img src="{{ asset('storage/event/') }}/${event.image}" class="img-thumbnail">`;
                    } else {
                        // Jika 'image' tidak ada, tampilkan gambar default
                        imageHtml = `<img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail">`;
                    }

                    // Tampilkan gambar dalam elemen 'image-preview'
                    imagePreview.innerHTML = imageHtml;

                    // Tampilkan detail event
                    // Potong deskripsi event jika lebih dari 80 karakter
                    var truncatedDescription = event.description.length > 110 ? event.description.substring(0, 110) + '...' : event.description;

                    // Format tanggal dan waktu
                    var formattedDate = new Date(event.date).toLocaleDateString('id-ID');

                    // Tampilkan informasi event
                    var table = document.getElementById('eventTableInfo');
                    table.innerHTML = `
                    <tr>
                         <td><i class="fas fa-calendar-alt"></i> ${formattedDate}</td>
                        <td><i class="fas fa-clock"></i> ${event.time}</td>
                        <td><i class="fas fa-map-marker-alt"></i> ${event.location}</td>
                    </tr>
                    `;
                    // Tampilkan detail event
                    var table = document.getElementById('eventTable');
                    table.innerHTML = `
                    <tr>
                        <td>${event.code}</td>
                        <td>${event.title}</td>
                        <td>${truncatedDescription}</td>
                    </tr>
                    `;

                    // Tentukan warna badge berdasarkan status event
                    var badgeColor = event.status == 'ACTIVE' ? 'success' : 'danger';
                    var badgeText = event.status == 'ACTIVE' ? 'OPEN' : 'CLOSE';

                    // Tampilkan quota event
                    var table = document.getElementById('eventTableQuota');
                    table.innerHTML = `
                    <tr>
                        <td><badge class="badge badge-${badgeColor}">${badgeText}</badge></td>
                        <td>QUOTA ${quota}</td>
                        <td>LIMIT ${event.count_limit}</td>
                    </tr>
                    `;

                    // Memformat harga dengan mata uang
                    const formattedPrice = new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR' // Ganti dengan kode mata uang yang sesuai
                    }).format(event.price);

                    // Tampilkan harga event
                    var table = document.getElementById('eventTableCost');
                    table.innerHTML = `
                    <tr>
                        <td><i class="fas fa-money-bill-wave"></i> <b>${formattedPrice}</b></td>
                        <td>${event.organizer}</td>
                    </tr>
                    `;
                }
            })
            .catch(error => {
                console.error(error);
            });
    });
</script>

@endsection
