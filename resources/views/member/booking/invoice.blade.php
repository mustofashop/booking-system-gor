@extends('layout.dashboard.app', ['title' => 'Invoice'])

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
    <div class="invoice">
        <div class="invoice-print">
            <div class="row">
                <div class="col-lg-12">
                    <div class="invoice-title">
                        <h2>Invoice</h2>
                        <div class="invoice-number">{{ $data->code }}</div>
                        <div class="badge badge-{{ $data->category == 'PAID' ? 'success' : 'danger' }}">
                            {{ $data->category }}
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <strong>Billed To:</strong><br>
                                @if ($data->booking->member)
                                {{ $data->booking->member->name }}<br>
                                {{ $data->booking->member->address }}<br>
                                {{ $data->booking->member->phone }}<br>
                                {{ $data->booking->member->email }}
                                @else
                                <div class="text-danger">
                                    <i class="fas fa-exclamation-circle"></i>
                                    MEMBER NOT FOUND
                                </div>
                                @endif
                            </address>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <address>
                                <strong>Event To:</strong><br>
                                {{ $data->booking->event->title }}<br>
                                {{ date('d F Y', strtotime($data->booking->event->date)) }}<br>
                                {{ $data->booking->event->time }}<br>
                                {{ $data->booking->event->location }}<br>
                            </address>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <address>
                                <strong>Payment Method:</strong><br>
                                {{ $data->methode }}<br>
                                {{ $data->description }}
                            </address>
                        </div>
                        <div class="col-md-6 text-md-right">
                            <address>
                                <strong>Reservation Date:</strong><br>
                                {{ date('d F Y', strtotime($data->date)) }}<br><br>
                            </address>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-12">
                    @foreach ($label as $item)
                    @if ($item->code == 'order')
                    <div class="section-title"><h3>{!! html_entity_decode($item->title) !!}</h3></div>
                    <p class="section-lead">{!! html_entity_decode($item->desc) !!}</p>
                    @endif
                    @endforeach
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-md">
                            <tbody>
                            <tr>
                                <th data-width="40" style="width: 40px;">#</th>
                                <th>Item</th>
                                <th class="text-center">Price</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-right">Totals</th>
                            </tr>
                            <tr>
                                <td>1</td>
                                <td>{{ $data->booking->event->title }}</td>
                                <td class="text-center">Rp. {{ number_format($data->booking->event->price, 0, ',', '.')
                                    }}
                                </td>
                                <td class="text-center">1</td>
                                <td class="text-right">Rp. {{ number_format($data->booking->event->price, 0, ',', '.')
                                    }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-8">
                            @foreach ($label as $item)
                            @if ($item->code == 'form.invoice')
                            <div class="section-title">{!! html_entity_decode($item->title) !!}</div>
                            <p class="section-lead">
                                {!! html_entity_decode($item->desc) !!}
                            </p>
                            @endif
                            @endforeach
                            <p class="section-lead">{{ $data->methode }}</p>
                            @foreach ($label as $item)
                            @if ($item->code == 'bank')
                            <p class="section-lead"><b>{!! html_entity_decode($item->title) !!}</b></p>
                            <p class="section-lead">
                                {!! html_entity_decode($item->desc) !!}
                            </p>
                            @endif
                            @endforeach
                        </div>
                        <div class="col-lg-4 text-right">
                            <div class="invoice-detail-item">
                                <div class="invoice-detail-name">Subtotal</div>
                                <div class="invoice-detail-value">Rp. {{ number_format($data->booking->event->price, 0,
                                    ',', '.')
                                    }}
                                </div>
                                <div class="invoice-detail-item">
                                    @foreach ($label as $item)
                                    @if ($item->code == 'service.fee')
                                    <div class="invoice-detail-name" title="{!! html_entity_decode($item->desc) !!}">
                                        {!! html_entity_decode($item->title) !!}
                                    </div>
                                    @endif
                                    @endforeach
                                    <div class="invoice-detail-value">Rp. {{ number_format($data->booking->event->cost,
                                        0, ',', '.')
                                        }}
                                    </div>
                                </div>
                                <hr class="mt-2 mb-2">
                                <div class="invoice-detail-item">
                                    <div class="invoice-detail-name">Total</div>
                                    <div class="invoice-detail-value invoice-detail-value-lg">Rp. {{
                                        number_format($data->booking->event->price + $data->booking->event->cost, 0,
                                        ',', '.')
                                        }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="text-md-right">
                <!--                <button class="btn btn-primary btn-icon icon-left"><i class="fas fa-credit-card"></i> Confirm Payment-->
                <!--                </button>-->
            </div>
        </div>
</section>
@endsection
