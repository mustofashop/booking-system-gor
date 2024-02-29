@extends('layout.dashboard.app', ['title' => 'Create Member'])

@section('content')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'member.create')
    <div class="section-title">
        <h3>{!! html_entity_decode($item->title) !!}</h3>
    </div>
    <p class="section-lead">
        {!! html_entity_decode($item->desc) !!}
    </p>
    @endif
    @endforeach
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h4>Create</h4>
                <div class="card-header-action">
                  <a href="{{ route('member.index') }}" class="btn btn-warning" data-toggle="tooltip"
                     title="Back"><i class="fas fa-backward"></i></a>
              </div>
              </div>
              <div class="card-body">
                <form id="fmuser" action="{{ route('member.store') }}" method="POST"
                          enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        <!-- IMAGE -->
                        <div class="row">
                        <div class="col-6">
                         <div id="image-preview" class="image-preview">
                             <img id="preview" src="" alt="Image Preview"
                                  style="max-width: 100%; max-height: 200px; display: none;">
                             <label for="image-upload" id="image-label">Choose File Image</label>
                             <input type="file" name="image" id="image-upload" required="">
                             <div class="invalid-feedback alert alert-danger mt-2">
                                 Please fill in the image
                             </div>
                         </div>
                     </div>
                     {{-- <div class="col-6">
                        <div id="image-preview" class="image-preview">
                            <img id="preview2" src="" alt="Image Preview"
                                 style="max-width: 100%; max-height: 200px; display: none;">
                            <label for="image-banner" id="image-label2">Choose File Banner</label>
                            <input type="file" name="banner" id="image-banner" required="">
                            <div class="invalid-feedback alert alert-danger mt-2">
                                Please fill in the image
                            </div>
                        </div>
                    </div>
                </div> --}}
                     {{-- <div class="row">
                        <div class="col-6">
                          <div class="form-group">
                              <label class="font-weight-bold">CODE</label>
                              <input type="text" class="form-control" name="code" value="{{ old('code') }}"
                                     placeholder="Enter code" required="">
                              <div class="invalid-feedback alert alert-danger mt-2">
                                  Please fill in the code
                              </div>
                          </div>
                      </div> --}}
                <!-- DESCRIPTION -->
                    <div class="col-6">
                      <div class="form-group">
                          <label class="font-weight-bold">NAME</label>
                          <input type="text" class="form-control" name="name" value="{{ old('name') }}"
                                 placeholder="Enter name" required="">
                                 <input type="hidden" id="code" name="code">
                          <div class="invalid-feedback alert alert-danger mt-2">
                              Please fill in the name
                          </div>
                      </div>
                  </div>
                </div>
               <!-- DATE -->
               <div class="row">
               <div class="col-6">
                <div class="form-group">
                    <label class="font-weight-bold">NICKNAME</label>
                          <input type="text" class="form-control" name="nickname" value="{{ old('nickname') }}"
                                 placeholder="Enter nickname" required="">
                          <div class="invalid-feedback alert alert-danger mt-2">
                              Please fill in the nickname
                          </div>
                </div>
            </div>
             <!-- DATE -->
             <div class="col-6">
              <div class="form-group">
                <label class="font-weight-bold">PLACE</label>
                <input type="text" class="form-control" name="place" value="{{ old('place') }}"
                       placeholder="Enter place" required="">
                <div class="invalid-feedback alert alert-danger mt-2">
                    Please fill in the place
                </div>
              </div>
          </div>
        </div>
        <!-- DATE -->
        <div class="row">
          <div class="col-6">
            <div class="form-group">
                <label class="font-weight-bold">DATE</label>
                    <input type="date" class="form-control" name="date"
                           value="{{ old('date') }}"
                           placeholder="Enter date" required="">
                    <div class="invalid-feedback alert alert-danger mt-2">
                        Please fill in the date
                    </div>
            </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-bold">GENDER</label>
                <select class="form-control select2" name="gender" value="{{ old('gender') }}"
                        placeholder="Pilih gender" required="">
                    <option value="">-- Choose --</option>
                    <option value="L">LAKI-LAKI</option>
                    <option value="P">PEREMPUAN</option>
                </select>
                <div class="invalid-feedback alert alert-danger mt-2">
                    Please fill in the gender
                </div>
            </div>
        </div>
    </div>
    <!-- DATE -->
    <div class="row">
      <div class="col-6">
       <div class="form-group">
           <label class="font-weight-bold">HEIGHT</label>
           <input type="text" class="form-control" name="height"
                  value="{{ old('height') }}"
                  placeholder="Enter height" required="">
           <div class="invalid-feedback alert alert-danger mt-2">
               Please fill in the height
           </div>
       </div>
   </div>
   <div class="col-6">
    <div class="form-group">
        <label class="font-weight-bold">WEIGHT</label>
           <input type="text" class="form-control" name="weight"
                  value="{{ old('weight') }}"
                  placeholder="Enter weight" required="">
           <div class="invalid-feedback alert alert-danger mt-2">
               Please fill in the weight
           </div>
    </div>
    </div>
    </div>
        <div class="row">
            <div class="col-6">
            <div class="form-group">
                <label class="font-weight-bold">ADDRESS</label>
                <input type="text" class="form-control" name="address"
                        value="{{ old('address') }}"
                        placeholder="Enter address" required="">
                <div class="invalid-feedback alert alert-danger mt-2">
            Please fill in the address
                </div>
        </div>
        </div>
    <div class="col-6">
        <div class="form-group">
            <label class="font-weight-bold">PHONE</label>
            <input type="number" class="form-control" name="phone"
                value="{{ old('phone') }}"
                placeholder="Enter phone" required="">
            <div class="invalid-feedback alert alert-danger mt-2">
                Please fill in the phone
            </div>
        </div>
    </div>
    </div>
    <div class="row">
        <div class="col-6">
        <div class="form-group">
            <label class="font-weight-bold">EMAIL</label>
            <input type="text" class="form-control" name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter email" required="">
            <div class="invalid-feedback alert alert-danger mt-2">
                Please fill in the email
            </div>
        </div>
        </div>
        <div class="col-6">
            <div class="form-group">
                <label class="font-weight-bold">SOCMED</label>
                <input type="text" class="form-control" name="socmed"
                        value="{{ old('socmed') }}"
                        placeholder="Enter socmed" required="">
                <div class="invalid-feedback alert alert-danger mt-2">
                    Please fill in the socmed
                </div>
            </div>
            </div>
            </div>
               <!-- STATUS -->
               <div class="row">
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
            <div class="col-6">
                <div class="form-group">
                    <label class="font-weight-bold">NUMBER BOOKING</label>
                    <input type="text" class="form-control" name="number_booking"
                            value="{{ old('number_booking') }}"
                            placeholder="Enter number booking" required="">
                    <div class="invalid-feedback alert alert-danger mt-2">
                        Please fill in the number booking
                    </div>
                </div>
                </div>
                </div>
                <div class="row">
                    <div class="col-6">
                    <div class="form-group">
                        <label class="font-weight-bold">NUMBER IDENTITY</label>
                        <input type="text" class="form-control" name="number_identity"
                                value="{{ old('number_identity') }}"
                                placeholder="Enter number identity" required="">
                        <div class="invalid-feedback alert alert-danger mt-2">
                            Please fill in the number identity
                        </div>
                    </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="font-weight-bold">STORY</label>
                            <input type="text" class="form-control" name="story"
                                    value="{{ old('story') }}"
                                    placeholder="Enter story" required="">
                            <div class="invalid-feedback alert alert-danger mt-2">
                                Please fill in the story
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

        $('#image-banner').change(function () {
            var file = this.files[0];
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#preview2').attr('src', e.target.result).show();
                $('#image-label2').text(file.name);
            };

            reader.readAsDataURL(file);
        });
    });
</script>

@endsection
