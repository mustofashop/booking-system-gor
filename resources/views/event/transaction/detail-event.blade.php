@extends('layout.dashboard.app', ['title' => 'List Event'])

@section('content')
<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'detail-member')
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
            <div class="card-body">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">    
                            <thead>
                            <tr style="text-align:left">
                                <th colspan="2">INFO RIDERS</th>
                                {{-- <th>NO PLAT RIDERS</th>
                                <th>NAMA RIDERS</th> --}}
                                <th>ORGANIZER</th>
                                <th colspan="2">DATE & ADDRESS</th>
                                <th>NOT CONFIRM</th>
                                <th>CONFIRM PAYMENT</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse ($items as $item)
                            <tr>
                                <td colspan="2">
                                    <div class="col-md-12">
                                        <p> <b> Nirp : </b> {{ $item->member->code }} </p>
                                    </div>
                                    <div class="col-md-12">
                                        <p> <b> No Plat : </b> {{ $item->member->number_plat }} </p>
                                    </div>
                                    <div class="col-md-12">
                                        <p> <i class="fas fa-user"></i> {{ $item->member->name }} </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-md-12">
                                        <p> <i class="fas fa-map-marker-alt"></i> {{ $item->event->organizer }} </p>
                                    </div>
                                </td>
                                <td colspan="2">
                                    <div class="col-md-12">
                                        <p> <i class="fas fa-calendar-alt"></i> {{ date('d F Y',
                                            strtotime($item->member->date)) }} </p> <b> <i class="fas fa-map-marker-alt"></i> {{ $item->member->address }} </b>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-md-12">
                                        <p> <i class="fas fa-money-bill-wave"></i> {{ $item->invoice->category}} </p>
                                    </div>
                                </td>
                                <td>
                                    <div class="col-md-12">
                                        <p> <i class="fas fa-money-bill-wave"></i> {{ $item->category}} </p>
                                    </div>
                                </td>
                            </div>
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
                        {{ $items->links('vendor.pagination.bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
@endsection