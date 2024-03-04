@extends('layout.details.default', ['title' => 'Event Detail'])
@section('content')

<style>
    .events-container-detail {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .event {
        flex: 1 1 calc(33.33% - 20px); /* Menggunakan flex untuk mengatur lebar */
        display: flex;
        border: 1px solid #ccc;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .event:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .event img {
        width: 200px; /* Mengatur lebar gambar */
        height: 100%;
        object-fit: cover;
        border-bottom: 1px solid #ddd;
    }

    .event-details {
        flex: 1; /* Menggunakan flex untuk mengisi sisa ruang */
        padding: 20px;
    }

    .event-title {
        margin-bottom: 10px;
    }

    .event-title h3 {
        margin: 0;
        font-size: 1.2rem;
        color: #333;
    }

    .event-info {
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 8px;
    }

    .event-description p {
        margin: 0;
        font-size: 0.9rem;
        color: #666;
        line-height: 1.6;
        margin-bottom: 15px;
    }
</style>


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
                            @if ($item->code == 'events')
                            <h3>{!!html_entity_decode($item->title)!!}</h3>
                            <h4>{!!html_entity_decode($item->desc)!!}</h4>
                            @endif
                            @endforeach


                            @foreach ($label as $item)
                            @if ($item->code == 'tagline.event')
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

    <!-- ======= Prosedur Section ======= -->
    <section id="event" class="features">
        <div class="container">

            <div class="section-title" data-aos="fade-up">
                <h2>{{ $event->title }}</h2>
                <p>#{{ $event->code }} , {{ date('d F Y', strtotime($event->date)) }}</p>
                <div class="event-info">
                    <h3>{{ $event->location }}</h3>
                    <h3>{{ date('H:i', strtotime($event->time)) }}</h3>
                </div>
            </div>

            <div class="events-container-detail">
                <div class="event">
                    @if ($event->image && Storage::exists('public/event/' . $event->image))
                    <a href="{{ asset('storage/event/'. $event->image) }}" target="_blank">
                        <img src="{{ asset('storage/event/'. $event->image) }}" alt="{{ $event->title }}">
                    </a>
                    @else
                    <img src="{{ asset('assets/img/default-image.jpg') }}" alt="{{ $event->title }}">
                    @endif

                    <div class="event-details">
                        <div class="event-title">
                            <h3>{{ $event->title }}</h3>
                            <strong
                                style="color: {{ $event->status == 'ACTIVE' ? 'green' : ($event->status == 'INACTIVE' ? 'red' : 'black') }}">
                                @if($event->status == 'ACTIVE')
                                <span>OPEN</span>
                                @elseif($event->status == 'INACTIVE')
                                <span>CLOSE</span>
                                @else
                                {{ $event->status }}
                                @endif
                                ( {{ $event->count_limit ? $event->count_limit : '0' }} )
                            </strong>
                        </div>
                        <div class="event-body">
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td>
                                        @foreach ($label as $item)
                                        @if ($item->code == 'event.io')
                                        <b title="{!!html_entity_decode($item->desc)!!}">{!!html_entity_decode($item->title)!!}</b>
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>:</td>
                                    <td>
                                        <div class="badge badge-primary">{{ $event->organizer }}</div>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        @foreach ($label as $item)
                                        @if ($item->code == 'event.open')
                                        <b title="{!!html_entity_decode($item->desc)!!}">{!!html_entity_decode($item->title)!!}</b>
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>:</td>
                                    <td>{{ date('d F Y H:i', strtotime($event->start_date)) }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        @foreach ($label as $item)
                                        @if ($item->code == 'event.close')
                                        <b title="{!!html_entity_decode($item->desc)!!}">{!!html_entity_decode($item->title)!!}</b>
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>:</td>
                                    <td>{{ date('d F Y H:i', strtotime($event->end_date)) }}</td>
                                </tr>
                                <tr>
                                    <td>
                                        @foreach ($label as $item)
                                        @if ($item->code == 'event.expired')
                                        <b title="{!!html_entity_decode($item->desc)!!}">{!!html_entity_decode($item->title)!!}</b>
                                        @endif
                                        @endforeach
                                    </td>
                                    <td>:</td>
                                    <td>{{ date('d F Y H:i', strtotime($event->expiry_date)) }}</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="event-description">
                            <p>{{ $event->description }}</p>
                        </div>
                        <div class="event-buttons">
                            @if($event->status == 'ACTIVE')

                            @foreach ($button as $item)
                            @if ( $item->code == 'order')

                            @if (Auth::check())
                            <a href="{{ route('booking.show', $event->id) }}"
                               class="btn btn-outline-success btn-block">{!!html_entity_decode($item->title)!!}</a>
                            @else
                            <a href="/login" class="btn btn-outline-success btn-block">{!!html_entity_decode($item->title)!!}</a>
                            @endif

                            @endif
                            @if ( $item->code == 'maps')
                            <a target="_blank" href="{{ $event->maps }}" class="btn btn-outline-dark btn-block">{!!html_entity_decode($item->title)!!}</a>
                            @endif
                            @endforeach

                            @elseif($event->status == 'INACTIVE')

                            @foreach ($button as $item)
                            @if ( $item->code == 'maps')
                            <a target="_blank" href="{{ $event->maps }}" class="btn btn-outline-dark btn-block">{!!html_entity_decode($item->title)!!}</a>
                            @endif
                            @endforeach
                            @else

                            @foreach ($button as $item)
                            @if ( $item->code == 'maps')
                            <a target="_blank" href="{{ $event->maps }}" class="btn btn-outline-dark btn-block">{!!html_entity_decode($item->title)!!}</a>
                            @endif
                            @endforeach

                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
    <!-- End Features Section -->

</main>
<!-- End #main -->
@endsection
