@extends('layout.dashboard.app', ['title' => 'Show Event'])

@section('content')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'event.show')
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
                <h4>Show</h4>
                <div class="card-header-action">
                  <a href="{{ route('event.index') }}" class="btn btn-warning" data-toggle="tooltip"
                     title="Back"><i class="fas fa-backward"></i></a>
              </div>
              </div>
              <div class="card-body">
                <form id="fmuser-show" action="{{ route('event.show', $data->id) }}" method="POST"
                    enctype="multipart/form-data" class="needs-validation" novalidate="">
                  @csrf
                  @method('PUT')
                        <!-- IMAGE -->
                        <div class="col-6">
                            <div id="image-preview" class="image-preview"
                                 data-image-url="{{ isset($user->image_url) ? asset('storage/event/' . $user->image_url) : '' }}">
                                <img id="preview"
                                     src="{{ isset($data->image) ? asset('storage/event/' . $data->image) : '' }}"
                                     alt="Image Preview" style="max-width: 100%; max-height: 200px; display: none;">
                                <label for="image-upload" id="image-label">Choose File</label>
                                <input type="file" name="image" id="image-upload">
                            </div>
                        </div>
                     <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                              <label class="font-weight-bold">TITLE</label>
                              <input type="text" class="form-control" name="title" value="{{ old('title', $data->title) }}"
                              placeholder="Enter title" readonly="">
                              <div class="invalid-feedback alert alert-danger mt-2">
                                  Please fill in the title
                              </div>
                          </div>
                      </div>
                      <div class="col-6">
                        <div class="form-group">
                            <label class="font-weight-bold">PRICE</label>
                            <input type="text" class="form-control" name="price" id="price" value="{{ old('price', $data->price) }}"
                                   placeholder="Enter price" readonly="">
                            <div class="invalid-feedback alert alert-danger mt-2">
                                Please fill in the name
                            </div>
                        </div>
                  </div>
                    </div>
                <!-- DESCRIPTION -->
                <div class="row">
                <div class="col-12">
                  <div class="form-group">
                    <label class="font-weight-bold">DESCRIPTION</label>
                    <textarea class="summernote-simple form-control" form="fmuser-show" name="description"
                              rows="5" readonly>{!! $data->description !!}</textarea>
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
                    <label class="font-weight-bold">DATE</label>
                    <input type="date" class="form-control" name="date" value="{{ old('date', $data->date) }}"
                           placeholder="Enter date" readonly="">
                    <div class="invalid-feedback alert alert-danger mt-2">
                        Please fill in the date
                    </div>
                </div>
            </div>
             <!-- DATE -->
             <div class="col-6">
              <div class="form-group">
                  <label class="font-weight-bold">TIME</label>
                  <input type="time" class="form-control" name="time" value="{{ old('time', $data->time) }}"
                         placeholder="Enter time" readonly="">
                  <div class="invalid-feedback alert alert-danger mt-2">
                      Please fill in the time
                  </div>
              </div>
          </div>
        </div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
                <label class="font-weight-bold">LOCATION</label>
                <input type="text" class="form-control" name="location" value="{{ old('location', $data->location) }}"
                       placeholder="Enter location" readonly="">
                <div class="invalid-feedback alert alert-danger mt-2">
                    Please fill in the location
                </div>
            </div>
        </div>
        <div class="col-6">
          <div class="form-group">
              <label class="font-weight-bold">MAPS</label>
              <input type="text" class="form-control" name="maps" value="{{ old('maps', $data->maps) }}"
                     placeholder="Enter maps" readonly="">
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
           <label class="font-weight-bold">ORGANIZER</label>
           <input type="text" class="form-control" name="organizer" value="{{ old('organizer', $data->organizer) }}"
                  placeholder="Enter organizer" readonly="">
           <div class="invalid-feedback alert alert-danger mt-2">
               Please fill in the organizer
           </div>
       </div>
   </div>
<div class="col-6">
  <div class="form-group">
      <label class="font-weight-bold">START DATE</label>
      <input type="datetime-local" class="form-control" name="start_date" value="{{ old('start_date', $data->start_date) }}"
             placeholder="Enter start_date" readonly="">
      <div class="invalid-feedback alert alert-danger mt-2">
          Please fill in the start_date
      </div>
  </div>
</div>
</div>
    <div class="row">
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-bold">END DATE</label>
            <input type="datetime-local" class="form-control" name="end_date" value="{{ old('end_date', $data->end_date) }}"
                placeholder="Enter end_date" readonly="">
            <div class="invalid-feedback alert alert-danger mt-2">
                Please fill in the end_date
            </div>
        </div>
    </div>
        <div class="col-6">
        <div class="form-group">
            <label class="font-weight-bold">EXPIRY DATE</label>
            <input type="datetime-local" class="form-control" name="expiry_date" value="{{ old('expiry_date', $data->expiry_date) }}"
                    placeholder="Enter expiry_date" readonly="">
            <div class="invalid-feedback alert alert-danger mt-2">
                Please fill in the expiry_date
            </div>
        </div>
        </div>
        </div>
                <!-- STATUS -->
                <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label class="font-weight-bold">STATUS</label>
                        <select class="form-control select2" name="status" value="{{ old('status', $data->status) }}"
                                placeholder="Pilih status" disabled>
                            <option value="">-- Choose --</option>
                            <option value="ACTIVE" {{ $data->status == 'ACTIVE' ? 'selected' : '' }}>ACTIVE</option>
                        <option value="INACTIVE" {{ $data->status == 'INACTIVE' ? 'selected' : ''
                        }}>INACTIVE</option>
                        </select>
                        <div class="invalid-feedback alert alert-danger mt-2">
                            Please fill in the status
                        </div>
                    </div>
                </div>
            </div>
            <!-- BUTTON -->
            {{-- <div class="form-group">
            <button type="submit" style="width:100px" class="btn btn-success btn-action"
                    data-toggle="tooltip" title="Save"><i class="fas fa-save"></i></button>
            <button type="reset" onclick="myReset()" class="btn btn-dark btn-action"
                    data-toggle="tooltip" title="Reset"><i class="fas fa-redo-alt"></i></button>
        </div> --}}
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

    // Code to load image when editing
    var imageUrl = '{{ isset($data->image) ? asset("storage/event/" . $data->image) : "" }}';
    if (imageUrl) {
        $('#preview').attr('src', imageUrl).show();
        $('#image-label').text('Change File');
    }

    //price

    /* Tanpa Rupiah */
    var tanpa_rupiah = document.getElementById('price');
    tanpa_rupiah.addEventListener('keyup', function(e) {
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
</script>

@endsection
