@extends('layout.details.default', ['title' => 'Confirm Payment'])
@section('content')
<main id="main">

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
                            <h4>{!!html_entity_decode($item->desc)!!}</h4>
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
    <section id="calendar" class="features">
        <div class="container">
            @foreach ($label as $item)
            @if ($item->code == 'payment')
            <div class="section-title">
                <h3>{!! html_entity_decode($item->title) !!}</h3>
            </div>
            @endif
            @endforeach

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr style="text-align:left">
                            <th>EVENT</th>
                            <th>PAYMENT</th>
                            <th>DESCRIPTION</th>
                            <th>STATUS</th>
                            <th colspan="2">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse ($data as $item)
                            <tr>
                                <td>
                                    <h3>{{ $item->booking->event->title }}</h3>
                                    <p><strong>{{ date('d F Y',
                                        strtotime($item->booking->event->date)) }}</strong></p>
                                    <b><i class="bx bx-time"></i> {{ date('H:i', strtotime($item->booking->event->time))}}</b>
                                    <p><i class="bx bx-map"></i> {{ $item->booking->event->location }}</p>
                                    <p><i class="bx bx-building-house"></i> {{ $item->booking->event->organizer }}</p>
                                </td>
                                <td>
                                    <div class="mt-3 mb-3">
                                        <div class="badge badge-dark mt-3 mb-3">
                                            {{ $item->code }}
                                        </div>
                                        <br>
                                        <i class="fas fa-money-bill-wave"></i> {{ $item->methode }}
                                        <br>
                                        <i class="bx bx-calendar-alt"></i> {{ date('d F Y', strtotime($item->date)) }}
                                    </div>
                                </td>
                                <td>
                                    <div class="mt-3 mb-3">
                                        <h3>Rp. {{ number_format($item->amount, 0, ',', '.') }}</h3>
                                        {!! Str::words(html_entity_decode($item->description), 80, ' ...') !!}
                                    </div>
                                </td>
                                <td>
                                    <div class="badge badge-{{ $item->category == 'PAID' ? 'success' : 'danger' }}">
                                        {{ $item->category }}
                                    </div>
                                </td>
                                <td colspan="2">
                                    @if ($item->category == 'UNPAID')
                                    <div class="row justify-content-md-center">
                                        <a href="{{ route('payment.edit', $item->id) }}" data-toggle="tooltip" title="Confirm">
                                           <button type="button" class="btn btn-warning">Confirm</button>
                                            <i class="fas fa-check"> </i>
                                        </a>
                                    </div>
                                    @else
                                    <div class="row justify-content-md-center">
                                        <a href="{{ route('payment.show', $item->id) }}"
                                           class="btn btn-info btn-action" data-toggle="tooltip" title="Show"><i
                                                class="fas fa-eye">
                                            </i>
                                        </a>
                                    </div>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <div class="alert alert-dark m-5">
                                Data not found
                            </div>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function deleteConfirmation(id) {
                swal({
                    title: "Are you sure you delete data ?",
                    text: "Please confirm and then confirm !",
                    type: "warning",
                    showCancelButton: !0,
                    confirmButtonText: "Delete",
                    cancelButtonText: "Cancel",
                    cancelButtonColor: "#F0E701",
                    confirmButtonColor: "#1AA13E",
                    reverseButtons: !0
                }).then(function (e) {
                    if (e.value === true) {
                        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                        $.ajax({
                            type: 'POST',
                            url: "{{url('/image/destroy')}}/" + id,
                            data: {
                                _token: CSRF_TOKEN,
                                "id": id
                            },
                            dataType: 'JSON',
                            success: function (results) {
                                if (results.success === true) {
                                    swal("Success", results.message, "success");
                                    window.location.replace("{{ url('payment') }}");
                                } else {
                                    swal("Failed", results.message, "error");
                                }
                            }
                        });
                    } else {
                        e.dismiss;
                    }
                }, function (dismiss) {
                    return false;
                })
            }
        </script>
    
    </section>
    <!-- End Calendar Section -->
</main>
<!-- End #main -->
@endsection
