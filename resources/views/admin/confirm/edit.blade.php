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
                    <h4>Edit</h4>
                    <div class="card-header-action">
                        <a href="{{ route('confirm.index') }}" class="btn btn-warning" data-toggle="tooltip"
                           title="Back"><i class="fas fa-backward"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <form id="fmlabel-edit" action="{{ route('confirm.store') }}" method="POST"
                          enctype="multipart/form-data" class="needs-validation" novalidate="">
                        @csrf
                        <div class="row">
                            <input type="hidden" name="event_id" value="{{ $data->booking->event_id }}">
                            <input type="hidden" name="invoice_number" value="{{ $data->code }}">
                            <!-- IMAGE -->
                            <div class="col-4">
                                <div id="image-preview" class="image-preview"
                                     data-image-url="{{ isset($data->file) ? asset('storage/payment/' . $data->file) : '' }}">
                                    <img id="preview"
                                         src="{{ isset($data->file) ? asset('storage/payment/' . $data->file) : '' }}"
                                         alt="Image Preview" style="max-width: 100%; max-height: 200px; display: none;">
                                    <label for="image-upload" id="image-label">Choose File</label>
                                    <input type="file" name="image" id="image-upload">
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
                                    <label class="font-weight-bold">METHODE</label>
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
                                    <label class="font-weight-bold">TO NAME</label>
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
                                    <label class="font-weight-bold">DATE</label>
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
                                    <label class="font-weight-bold">NOTE</label>
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
                                    <label class="font-weight-bold">AMOUNT</label>
                                    <input type="number" class="form-control" name="amount"
                                           value="{{ old('amount', $data->amount) }}"
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
    var imageUrl = '{{ isset($data->image) ? asset("storage/payment/" . $data->image) : "" }}';
    if (imageUrl) {
        $('#preview').attr('src', imageUrl).show();
        $('#image-label').text('Change File');
    }
</script>
@endsection
