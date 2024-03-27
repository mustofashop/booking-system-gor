@extends('layout.dashboard.app', ['title' => 'Create Event'])

@section('content')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'event.create')
    <div class="section-title">
        <h3>{!! html_entity_decode($item->title) !!}</h3>
    </div>
    <p class="section-lead">
        {!! html_entity_decode($item->desc) !!}
    </p>
    @endif
    @endforeach

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Create</h4>
                    <div class="card-header-action">
                        <a href="{{ route('event.index') }}" class="btn btn-warning" data-toggle="tooltip"
                           title="Back"><i class="fas fa-backward"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="fmuser" action="{{ route('event.store') }}" method="POST"
                          enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        <!-- IMAGE -->
                        <div class="row mb-5">
                            <div class="col-6">
                                <label class="font-weight-bold">IMAGE EVENT <span
                                        class="text-danger">*</span></label>
                                <div id="image-preview" class="image-preview">
                                    <img id="preview" src="" alt="Image Preview"
                                         style="max-width: 100%; max-height: 200px; display: none;">
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="image" id="image-upload" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the image
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="font-weight-bold">PHOTO CIRCUIT <span
                                        class="text-danger">*</span></label>
                                <div id="image-preview" class="image-preview">
                                    <img id="preview2" src="" alt="Image Preview"
                                         style="max-width: 100%; max-height: 200px; display: none;">
                                    <label for="image-upload2" id="image-label2">Choose File</label>
                                    <input type="file" name="photo_circuit" id="image-upload2" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the photo circuit
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">TITLE <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title') }}"
                                           placeholder="Enter title" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the title
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">PRICE <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="price" id="price"
                                           value="{{ old('price') }}"
                                           placeholder="Enter price" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the price
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">GATE <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="gate" id="gate"
                                           value="{{ old('gate') }}"
                                           placeholder="Enter gate" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the gate
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">SERVICE FEE <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="cost" id="cost"
                                           value="{{ old('cost', $cost->amount) }}"
                                           placeholder="Enter cost" required="" readonly>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the cost
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">INFO CIRCUIT <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="info_circuit" id="info_circuit"
                                           value="{{ old('info_circuit') }}"
                                           placeholder="Enter info_circuit" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the info circuit
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- DESCRIPTION -->
                        <div class="row mt-5">
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">DESCRIPTION <span
                                            class="text-danger">*</span></label>
                                    <textarea class="summernote-simple form-control" name="description" rows="5"
                                              placeholder="Enter description"
                                              required="">{{ old('description') }}</textarea>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the description
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- DATE -->
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">DATE <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="date" value="{{ old('date') }}"
                                           placeholder="Enter date" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the date
                                    </div>
                                </div>
                            </div>
                            <!-- DATE -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">TIME <span
                                            class="text-danger">*</span></label>
                                    <input type="time" class="form-control" name="time" value="{{ old('time') }}"
                                           placeholder="Enter time" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the time
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">LOCATION <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="location"
                                           value="{{ old('location') }}"
                                           placeholder="Enter location" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the location
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">MAPS <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="maps" value="{{ old('maps') }}"
                                           placeholder="Enter maps" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the maps
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- DATE -->
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">ORGANIZER <span
                                            class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="organizer"
                                           value="{{ old('organizer') }}"
                                           placeholder="Enter organizer" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the organizer
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">QUOTA <span
                                            class="text-danger">*</span></label>
                                    <input type="number" class="form-control" name="count_limit"
                                           value="{{ old('count_limit') }}"
                                           placeholder="Enter quota" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the quota
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h3>Registration</h3>
                        <hr>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">START DATE <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" name="start_date"
                                           value="{{ old('start_date') }}"
                                           placeholder="Enter start_date" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the start_date
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">END DATE <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" name="end_date"
                                           value="{{ old('end_date') }}"
                                           placeholder="Enter end_date" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the end_date
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- STATUS -->
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">EXPIRY DATE <span
                                            class="text-danger">*</span></label>
                                    <input type="datetime-local" class="form-control" name="expiry_date"
                                           value="{{ old('expiry_date') }}"
                                           placeholder="Enter expiry_date" required="">
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the expiry_date
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">STATUS</label>
                                    <select class="form-control select2" name="status" value="{{ old('status') }}"
                                            placeholder="Pilih status" required="">
                                        <option value="">-- Choose --</option>
                                        <option value="ACTIVE">ACTIVE</option>
                                        <option value="INACTIVE">INACTIVE</option>
                                    </select>
                                    <div class="invalid-feedback alert alert-danger mt-2">
                                        Please fill in the status
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- BUTTON -->
                        <div class="form-group">
                            <button type="submit" style="width:100px" class="btn btn-success btn-action"
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
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

    $(document).ready(function () {
        $('#image-upload2').change(function () {
            var file = this.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview2').attr('src', e.target.result).show();
                $('#image-label2').text(file.name);
            };

            reader.readAsDataURL(file);
        });
    });

    /* Tanpa Rupiah */
    var tanpa_rupiah = document.getElementById('price');
    tanpa_rupiah.addEventListener('keyup', function (e) {
        tanpa_rupiah.value = formatRupiah(this.value);
    });

    /* Fungsi */
    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^,\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    }

    /* COST */

    /* Tanpa Rupiah */
    // var tanpa_rupiah = document.getElementById('cost');
    // tanpa_rupiah.addEventListener('keyup', function (e) {
    //     tanpa_rupiah.value = formatRupiah(this.value);
    // });

    // /* Fungsi */
    // function formatRupiah(angka, prefix) {
    //     var number_string = angka.replace(/[^,\d]/g, '').toString(),
    //         split = number_string.split(','),
    //         sisa = split[0].length % 3,
    //         rupiah = split[0].substr(0, sisa),
    //         ribuan = split[0].substr(sisa).match(/\d{3}/gi);

    //     if (ribuan) {
    //         separator = sisa ? '.' : '';
    //         rupiah += separator + ribuan.join('.');
    //     }

    //     rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
    //     return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
    // }
</script>

@endsection
