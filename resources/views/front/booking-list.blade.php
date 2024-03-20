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
                            @if ($item->code == 'booking-list')
                            <h3>{!!html_entity_decode($item->title)!!}</h3>
                            <h4>{!!html_entity_decode($item->desc)!!}</h4>
                            @endif
                            @endforeach


                            @foreach ($label as $item)
                            @if ($item->code == 'booking-list')
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
    <section id="booking-list" class="features">
        <div class="container">
        <div class="section-title" data-aos="fade-up">
            @foreach ($label as $item)
            @if ($item->code == 'booking-list')
            <h2>{!!html_entity_decode($item->title)!!}</h2>
            <p><i class="bx bx-notepad">
            &nbsp; </i>{!!html_entity_decode($item->desc)!!}</p>
            @endif
            @endforeach
        </div>
        <div class="row" data-aos="fade-up" data-aos-delay="100">
            <div class="col-lg-12 mt-4 mt-lg-0">
                <form action="{{ route('booking-list') }}" method="GET">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Search Event" name="search"
                        value="{{ request()->get('search') }}">
                        <select class="form-control" name="month">
                            <option value="">Select Month</option>
                            <option value="01">January</option>
                            <option value="02">February</option>
                            <option value="03">March</option>
                            <option value="04">April</option>
                            <option value="05">May</option>
                            <option value="06">June</option>
                            <option value="07">July</option>
                            <option value="08">August</option>
                            <option value="09">September</option>
                            <option value="10">October</option>
                            <option value="11">November</option>
                            <option value="12">December</option>
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr style="text-align:left">
                            <th colspan="2">BOOKING</th>
                            <th>INFO</th>
                            <th>MEMBER</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($booking as $item)
                        <tr>
                            <td>
                                @if ($item->event->image && Storage::exists('public/event/' . $item->event->image))
                                <img src="{{ asset('storage/event/' . $item->event->image) }}" class="img-thumbnail"
                                        width="100">
                                @else
                                <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail"
                                        width="100">
                                @endif
                            </td>
                            <td>
                                <div class="event-info mt-3 mb-3">
                                    <h6> RESERVATION : <b> {{ date('d F Y', strtotime($item->date)) }} </b></h6>
                                    <h3>{{ $item->event->title }}</h3>
                                    <div class="badge badge-dark">{{ $item->code }}</div>
                                    <div
                                        class="badge badge-{{ $item->event->status == 'ACTIVE' ? 'success' : 'danger' }}">
                                        @if($item->event->status == 'ACTIVE')
                                        <span>OPEN</span>
                                        @elseif($item->event->status == 'INACTIVE')
                                        <span>CLOSE</span>
                                        @else
                                        {{ $item->event->status }}
                                        @endif
                                    </div>
                                    <br>
                                    <br>
                                    <i class="bx bx-calendar"></i> {{ date('d F Y',
                                    strtotime($item->event->date)) }}
                                    <i class="bx bx-time"></i>{{ date('H:i',
                                    strtotime($item->event->time)) }}
                                    <i class="bx bx-map"></i> {{ $item->event->location }}
                                </div>
                            </td>
                            <td>
                                <div class="event-info mt-3 mb-3">
                                    <i class="bx bxs-buildings"></i> {{ $item->event->organizer }}
                                    <br>
                                    <p>{!! Str::words(html_entity_decode($item->note), 80, ' ...') !!} </p>
                                    <h3>Rp. {{ number_format($item->event->price, 0, ',', '.') }}</h3>
                                    <a href="{{ $item->event->maps }}" target="_blank" class="mb-3">{{
                                        $item->event->maps }}</a>
                                </div>
                            </td>
                            <td>
                                <div class="event-info">
                                    <i class="bx bx-user"></i> {{ strtoupper($item->member->name) }} <br>
                                    <i class="bx bxs-user-detail"></i> {{ strtoupper($item->member->nickname) }} <br>
                                    <i class="bx bx-map"></i> {{ strtoupper($item->member->place) }} ,
                                    {{ date('d F Y', strtotime($item->member->date)) }} <br>
                                    <i class="bx bxs-envelope"></i> {{ $item->member->email }} <br>
                                    <i class="bx bxs-phone"></i> {{ $item->member->phone }} <br>
                                    <div
                                        class="badge badge-{{ $item->category == 'RESERVATION' ? 'info' : 'warning' }}">
                                        {{ $item->category }}
                                    </div>
                                </div>
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
            <div class="d-felx justify-content-center">
                <div class="card-footer text-right">
                    {{ $data->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
       </section>
        @endsection