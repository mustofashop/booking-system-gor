@extends('layout.dashboard.app', ['title' => 'Confirm Payment'])

@section('content')

<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'payment.edit')
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
                    <h4>Payment Verification</h4>
                    <div class="card-header-action">
                        <a href="{{ route('confirm.index') }}" class="btn btn-warning" data-toggle="tooltip"
                           title="Back"><i class="fas fa-backward"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="fmlabel-edit" action="{{ route('confirm.update', $data->payment[0]->id) }}" method="post"
                          enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- IMAGE -->
                            <div class="col-4">
                                <div id="image-preview" class="image-preview"
                                     data-image-url="{{ isset($data->payment[0]->file) ? asset('storage/payment/' . $data->payment[0]->file) : '' }}">
                                    @if ($data->payment[0]->file && Storage::exists('public/payment/' .
                                    $data->payment[0]->file))
                                    <a href="{{ asset('storage/payment/'. $data->payment[0]->file) }}" target="_blank">
                                        <img id="preview"
                                             src="{{ isset($data->payment[0]->file) ? asset('storage/payment/' . $data->payment[0]->file) : '' }}"
                                             alt="Image Preview"
                                             style="max-width: 100%; max-height: 200px; display: none;">
                                    </a>
                                    @else
                                    <img src="{{ asset('assets/img/default-image.jpg') }}">
                                    @endif

                                </div>
                            </div>
                            <!-- CODE -->
                            <div class="col-8">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label class="font-weight-bold">INVOICE</label>
                                            <input type="text" class="form-control" name="code"
                                                   value="{{ $data->code }}"
                                                   placeholder="Enter code" required="" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">METODHE</label>
                                            <input type="text" class="form-control" name="code"
                                                   value="{{ $data->methode }}"
                                                   placeholder="Enter methode" required="" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">DATE</label>
                                            <input type="text" class="form-control" name="code"
                                                   value="{{ date('d F Y', strtotime($data->date)) }}"
                                                   placeholder="Enter date" required="" readonly>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">AMOUNT</label>
                                            <h3>Rp. {{ number_format($data->amount, 0, ',', '.') }}</h3>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label class="font-weight-bold">DESCRIPTION</label>
                                            <textarea class="form-control" name="desc"
                                                      placeholder="Enter description" required="">{{ $data->description }}</textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- SENDER -->
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">SENDER NAME</label>
                                    <input type="text" class="form-control" name="sender"
                                           value="{{ $data->payment[0]->sender }}"
                                           placeholder="Enter sender" required="" readonly>
                                </div>
                            </div>
                            <!-- METODE -->
                            <div class="col-6 mt-3">
                                <div class="form-group">
                                    <label class="font-weight-bold">METHODE</label>
                                    <select class="form-control" name="methode" required="">
                                        <option value="TRANSFER" {{ $data->payment[0]->methode == 'TRANSFER' ?
                                            'selected' : '' }}>
                                            TRANSFER
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <!-- FROM -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">TO NAME</label>
                                    <input type="text" class="form-control" name="from"
                                           value="{{ $data->payment[0]->from }}"
                                           placeholder="Enter from" required="" readonly>
                                </div>
                            </div>
                            <!-- DATE -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">DATE</label>
                                    <input type="date" class="form-control" name="paid_date"
                                           value="{{ old('date', date('Y-m-d', strtotime($data->payment[0]->paid_date))) }}"
                                           max="{{ date('Y-m-d') }}"
                                           placeholder="Enter paid date" required="" readonly>
                                </div>
                            </div>
                            <!-- NOTE -->
                            <div class="col-12">
                                <div class="form-group">
                                    <label class="font-weight-bold">NOTE</label>
                                    <textarea class="form-control" name="note"
                                              placeholder="Enter note" disabled>{{ old('note', $data->payment[0]->note) }}</textarea>
                                </div>
                            </div>
                            <!-- AMOUNT -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">AMOUNT</label>
                                    <input type="number" class="form-control" name="amount"
                                           value="{{ old('amount', $data->amount) }}"
                                           placeholder="Enter amount" required="" readonly>
                                </div>
                            </div>
                            <!-- STATUS -->
                            <div class="col-6">
                                <div class="form-group">
                                    <label class="font-weight-bold">STATUS</label>
                                    <select class="form-control" name="category" required="">
                                        <option value="">-- Choose --</option>
                                        <option value="VALID">
                                            APPROVED
                                        </option>
                                        <!--                                        <option value="INVALID">-->
                                        <!--                                            REJECTED-->
                                        <!--                                        </option>-->
                                    </select>
                                    <div class="invalid-feedback">
                                        Please select a valid status.
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

    // Code to load image when editing
    var imageUrl = '{{ isset($data->payment[0]->file) ? asset("storage/payment/" . $data->payment[0]->file) : "" }}';
    if (imageUrl) {
        $('#preview').attr('src', imageUrl).show();
        $('#image-label').text('Change File');
    }
</script>
