@extends('layout.details.default', ['title' => 'List Booking'])
@section('content')
<main id="main">
    {{-- Message --}}
@if (Session::has('success'))
<div class="alert alert-success alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Success !</strong> {{ session('success') }}
</div>
@endif

{{-- menampilkan error validasi --}}
@if (count($errors) > 0)
<div class="alert alert-danger alert-dismissible" role="alert">
    <button type="button" class="close" data-dismiss="alert">
        <i class="fa fa-times"></i>
    </button>
    <strong>Failed !</strong>
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif


    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
        <div class="container">
            <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="{{asset('assets/img/logo-white.svg')}}" alt="website logo"
                                 class="logo-dark mxw-300" width="382" height="157">
                            @foreach ($label as $item)
                            @if ($item->code == 'payment')
                            <h3>{!!html_entity_decode($item->title)!!}</h3>
                            {{-- <h4>{!!html_entity_decode($item->desc)!!}</h4> --}}
                            @endif
                            @endforeach


                            @foreach ($label as $item)
                            @if ($item->code == 'tagline.payment')
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                {!!html_entity_decode($item->desc)!!}
                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>
                            @endif
                            @endforeach

                        </div>
                    </div>
                    <!-- End testimonial item -->
                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section>
    <!-- End Testimonials Section -->

    <!-- ======= Calendar Section ======= -->
    <section id="confirms-payment" class="features">
    <div class="container">
    <div class="section-title" data-aos="fade-up">
        @foreach ($label as $item)
        @if ($item->code == 'confirms-payment')
        <h2>{!!html_entity_decode($item->title)!!}</h2>
        <p><i class="bx bx-money">
        &nbsp; </i>{!!html_entity_decode($item->desc)!!}</p>
        @endif
        @endforeach
    </div>
    <div class="card-body">
        <form id="fmlabel-edit" action="{{ route('confirms-payment.store') }}" method="POST"
              enctype="multipart/form-data" class="needs-validation" novalidate="">
            @csrf
            <div class="row">
                <!-- IMAGE -->
                <div class="col-4">
                    <div class="form-group">
                        <label class="font-weight-bold">FILE TRANSFER</label>
                        <div id="image-preview" class="image-preview"
                            data-image-url="{{ isset($data->file) ? asset('storage/payment/' . $data->file) : '' }}">
                            <img id="preview"
                                src="{{ isset($data->file) ? asset('storage/payment/' . $data->file) : '' }}"
                                alt="Image Preview" style="max-width: 100%; max-height: 200px; display: none;">
                            <label for="image-upload" id="image-label">Choose File</label>
                            <input type="file" name="image" id="image-upload">
                        </div>
                        <div class="invalid-feedback">
                            Please fill in the image
                        </div>
                    </div>
                </div>
                {{-- // Tambahakan slecet2 untuk mencari event untuk mengisi field yg readonly --}}
                <!-- EVENT -->
                        <div class="col-8">
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
                        </div>
                            <!-- EVENT INFO -->
                            <div class="form-group">
                                <label for="event_id" class="font-weight-bold">EVENT INFO <span
                                    class="text-danger">*</span></label>
                                <div class="table-responsive">
                                    <table id="eventTableInfo" class="table table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th>CODE</th>
                                            <th>NAME</th>
                                            <th>PRICE</th>
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
                <!-- INVOICE -->
                <div class="col-6 mt-3">
                    <div class="form-group">
                        <label class="font-weight-bold">INVOICE <span
                            class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="invoice_number" value="{{ old('invoice_number') }}"
                               placeholder="Enter Invoice Number" required="">
                        <div class="invalid-feedback">
                            Please fill in the invoice number name
                        </div>
                    </div>
                </div>
                <!-- SENDER -->
                <div class="col-6 mt-3">
                    <div class="form-group">
                        <label class="font-weight-bold">SENDER NAME <span
                            class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="sender" value="{{ old('sender') }}"
                               placeholder="Enter sender" required="">
                        <div class="invalid-feedback">
                            Please fill in the sender name
                        </div>
                    </div>
                </div>
                <!-- METODE -->
                <div class="col-6 mt-3">
                    <div class="form-group">
                        <label class="font-weight-bold">METHODE <span
                            class="text-danger">*</span></label>
                        <select class="form-control" name="methode" required="">
                            <option value="TRANSFER">
                                TRANSFER
                            </option>
                        </select>
                        <div class="invalid-feedback">
                            Please select the methode payment
                        </div>
                    </div>
                </div>
                <!-- FROM -->
                <div class="col-6">
                    <div class="form-group">
                        <label class="font-weight-bold">TO NAME <span
                            class="text-danger">*</span></label>
                        <input type="text" class="form-control" name="from" value="{{ old('from') }}"
                               placeholder="Enter from" required="">
                        <div class="invalid-feedback">
                            Please fill in the from name
                        </div>
                    </div>
                </div>
                <!-- DATE -->
                <div class="col-6">
                    <div class="form-group">
                        <label class="font-weight-bold">DATE <span
                            class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="paid_date"
                               value="{{ old('date', date('Y-m-d')) }}"
                               max="{{ date('Y-m-d') }}"
                               placeholder="Enter paid date" required="">
                        <div class="invalid-feedback">
                            Please fill in the paid date
                        </div>
                    </div>
                </div>
                <!-- NOTE -->
                <div class="col-6">
                    <div class="form-group">
                        <label class="font-weight-bold">NOTE <span
                            class="text-danger">*</span></label>
                        <textarea class="form-control" name="note"
                                  placeholder="Enter note" required="">{{ old('note') }}</textarea>
                        <div class="invalid-feedback">
                            Please fill in the note
                        </div>
                    </div>
                </div>
                <!-- AMOUNT -->
                <div class="col-6">
                    <div class="form-group">
                        <label class="font-weight-bold">AMOUNT <span
                            class="text-danger">*</span></label>
                        <input type="number" class="form-control" name="amount"
                               value="{{ old('amount') }}"
                               placeholder="Enter amount" required="">
                        <div class="invalid-feedback">
                            Please fill in the amount
                        </div>
                    </div>
                </div>
            </div>
            <!-- BUTTON -->
            <div class="form-group">
                <button type="submit" style="width:100px" class="btn btn-success btn-action"
                        data-toggle="tooltip" title="Save"><i class="bx bx-save"></i></button>
                <button type="reset" onclick="myReset()" class="btn btn-dark btn-action"
                        data-toggle="tooltip" title="Reset"><i class="bx bx-history "></i></button>
            </div>
        </form>
    </div>
</section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <!-- include select2 css/js -->
 <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

 <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">

 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script>
    $(document).ready(function () {
        $('#image-upload').change(function () {
            var file = this.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result).show();
                $('#image-label').text(file.name);
            };

            reader.readAsDataURL(file);
        });
    });

    // Code to load image when editing
    var imageUrl = '{{ isset($data->image) ? asset("storage/payment/" . $data->image) : "" }}';
    if (imageUrl) {
        $('#preview').attr('src', imageUrl).show();
        $('#image-label').text('Change File');
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#event_id').on('change', function () {
            var eventId = $(this).val();

            fetch('/getConfirmById/' + eventId)
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
                        
                        var eventTableInfo = document.getElementById('eventTableInfo');
                        eventTableInfo.innerHTML = `
                            <tr>
                                <td><i class="bx bx-time"></i> ${event.code}</td>
                                <td><i class="bx bx-building-house"></i> ${event.title}</td>
                                <td><i class="bx bx-money"></i> ${event.price}</td>
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