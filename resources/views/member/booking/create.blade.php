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
                            <input type="hidden" name="member_id" id="member_id" value="{{ old('member_id') }}">
                            <!-- ACCOUNT -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="member_id" class="font-weight-bold">ACCOUNT <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" value="{{ $member->user->name }} | {{
                                        $member->user->email }} | {{ $member->user->phone }}" readonly>
                                    <div class="invalid-feedback">
                                        Please select a valid account
                                    </div>
                                </div>
                            </div>
                            <!-- MEMBER -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="code" class="font-weight-bold">MEMBER <span
                                            class="text-danger">*</span></label>
                                    <input id="code" type="text" class="form-control" name="code"
                                           value="{{ $member->code }} | {{ $member->name }} | {{ $member->place }},
                                           {{ date('d F Y', strtotime($member->date)) }}"
                                           placeholder=" Enter code" required="" readonly>
                                    <div class="invalid-feedback">
                                        Please fill in the code
                                    </div>
                                </div>
                            </div>
                            <hr class="m-3" style="width:100%;text-align:left;margin-left:0; color:black">
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
                                    <select id="event_id" name="event_id" class="select2 form-control" required="">
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
    document.addEventListener('DOMContentLoaded', function () {
        $('#member_id').on('change', function () {
            var memberId = $(this).val();

            // Kirim permintaan GET menggunakan fetch
            fetch('/getMemberById/' + memberId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to get member');
                    }
                    return response.json();
                })
                .then(data => {
                    // Tampilkan data member
                    if (data) {
                        const member = data.member;

                        // Tampilkan nama member
                        $('#name').val(member.name).trigger('change');
                        $('#code').val(member.code).trigger('change');
                        $('#birthday').val(member.place + ', ' + new Date(member.date).toLocaleDateString('id-ID')).trigger('change');
                    } else {
                        $('#name').val('').trigger('change');
                        $('#code').val('').trigger('change');
                        $('#birthday').val('').trigger('change');
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#event_id').on('change', function () {
            var eventId = $(this).val();

            fetch('/getEventById/' + eventId)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to get event');
                    }
                    return response.json();
                })
                .then(data => {
                    if (data) {
                        const event = data.event;
                        const quota = data.quota;

                        var imagePreview = document.getElementById('image-preview');
                        var imageHtml = '';

                        if (event.image && event.image != '') {
                            imageHtml = `<img src="{{ asset('storage/event/') }}/${event.image}" class="img-thumbnail">`;
                        } else {
                            imageHtml = `<img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail">`;
                        }
                        imagePreview.innerHTML = imageHtml;

                        var formattedDate = new Date(event.date).toLocaleDateString('id-ID');

                        var eventTableInfo = document.getElementById('eventTableInfo');
                        eventTableInfo.innerHTML = `
                            <tr>
                                <td><i class="fas fa-calendar-alt"></i> ${formattedDate}</td>
                                <td><i class="fas fa-clock"></i> ${event.time}</td>
                                <td><i class="fas fa-map-marker-alt"></i> ${event.location}</td>
                            </tr>
                        `;

                        var eventTable = document.getElementById('eventTable');
                        eventTable.innerHTML = `
                            <tr>
                                <td>${event.code}</td>
                                <td>${event.title}</td>
                                <td>${event.description.length > 110 ? event.description.substring(0, 110) + '...' : event.description}</td>
                            </tr>
                        `;

                        var badgeColor = event.status == 'ACTIVE' ? 'success' : 'danger';
                        var badgeText = event.status == 'ACTIVE' ? 'OPEN' : 'CLOSE';

                        var eventTableQuota = document.getElementById('eventTableQuota');
                        eventTableQuota.innerHTML = `
                            <tr>
                                <td><badge class="badge badge-${badgeColor}">${badgeText}</badge></td>
                                <td>QUOTA ${quota}</td>
                                <td>LIMIT ${event.count_limit}</td>
                            </tr>
                        `;

                        const formattedPrice = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(event.price);

                        const formattedCost = new Intl.NumberFormat('id-ID', {
                            style: 'currency',
                            currency: 'IDR'
                        }).format(event.cost);

                        var eventTableCost = document.getElementById('eventTableCost');
                        eventTableCost.innerHTML = `
                            <tr>
                                <td><i class="fas fa-money-bill-wave"></i> Price <b>${formattedPrice}</b></td>
                                <td><i class="fas fa-money-bill-wave"></i> Fee <b>${formattedCost}</b></td>
                                <td>${event.organizer}</td>
                            </tr>
                        `;
                    } else {
                        var imagePreview = document.getElementById('image-preview');
                        imagePreview.innerHTML = `<img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail">`;

                        var eventTableInfo = document.getElementById('eventTableInfo');
                        eventTableInfo.innerHTML = `
                            <tr>
                                <td colspan="3" class="text-center">No data available in table</td>
                            </tr>
                        `;

                        var eventTable = document.getElementById('eventTable');
                        eventTable.innerHTML = `
                            <tr>
                                <td colspan="3" class="text-center">No data available in table</td>
                            </tr>
                        `;

                        var eventTableQuota = document.getElementById('eventTableQuota');
                        eventTableQuota.innerHTML = `
                            <tr>
                                <td colspan="3" class="text-center">No data available in table</td>
                            </tr>
                        `;

                        var eventTableCost = document.getElementById('eventTableCost');
                        eventTableCost.innerHTML = `
                            <tr>
                                <td colspan="3" class="text-center">No data available in table</td>
                            </tr>
                        `;
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        });
    });
</script>

@endsection
