@extends('layout.details.default', ['title' => 'Event'])
@section('content')

<style>
    .events-container {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        gap: 20px;
    }

    .event {
        width: calc(33.33% - 20px);
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
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-bottom: 1px solid #ddd;
    }

    .event-details {
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
        display: flex;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .event-info span {
        font-size: 0.9rem;
        color: #777;
    }

    .event-description {
        margin-bottom: 10px;
    }

    .event-description p {
        margin: 0;
        font-size: 0.9rem;
        color: #555;
    }

    /* Responsive styling for smaller screens */
    @media (max-width: 768px) {
        .event {
            width: calc(50% - 20px);
        }
    }

    @media (max-width: 576px) {
        .event {
            width: calc(100% - 20px);
        }
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
                @foreach ($label as $item)
                @if ($item->code == 'events')
                <h2>{!!html_entity_decode($item->title)!!}</h2>
                <p>{!!html_entity_decode($item->desc)!!}</p>
                @endif
                @endforeach
            </div>

            <section class="container">
                <div class="events-container">
                    @foreach ($events as $event)
                    <div class="event">
                        @if ($event->image && Storage::exists('public/event/' . $event->image))
                        <a href="{{ asset('storage/event/'. $event->image) }}" target="_blank">
                            <img src="{{ asset('storage/event/'. $event->image) }}" alt="{{ $event->title }}">
                        </a>
                        @else
                        <img src="{{ asset('assets/img/default-image.jpg') }}" alt="{{ $event->title }}">
                        @endif

                        <div class="event-details">
                            <div class="event-info">
                                <span>#{{ $event->code }}</span>
                                <span>{{ date('d F Y', strtotime($event->date)) }}</span>
                            </div>
                            <div class="event-info">
                                <span>{{ $event->location }}</span>
                                <span>{{ date('H:i', strtotime($event->time)) }}</span>
                            </div>
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
                            <div class="event-description">
                                <p>{!! Str::words(html_entity_decode($event->description), 70, ' ...') !!}</p>
                            </div>
                            <div class="event-buttons">
                                @if($event->status == 'ACTIVE')

                                @foreach ($button as $item)
                                @if ( $item->code == 'read')
                                <a href="{{ route('event-show', $event->id) }}"
                                   class="btn btn-outline-danger btn-block">{!!html_entity_decode($item->title)!!}</a>
                                @endif
                                @if ( $item->code == 'order')
                                <a href="#" class="btn btn-outline-success btn-block">{!!html_entity_decode($item->title)!!}</a>
                                @endif
                                @if ( $item->code == 'maps')
                                <a target="_blank" href="{{ $event->maps }}" class="btn btn-outline-dark btn-block">{!!html_entity_decode($item->title)!!}</a>
                                @endif
                                @endforeach

                                @elseif($event->status == 'INACTIVE')

                                @foreach ($button as $item)
                                @if ( $item->code == 'read')
                                <a href="{{ route('event-show', $event->id) }}"
                                   class="btn btn-outline-danger btn-block">{!!html_entity_decode($item->title)!!}</a>
                                @endif
                                @if ( $item->code == 'maps')
                                <a target="_blank" href="{{ $event->maps }}" class="btn btn-outline-dark btn-block">{!!html_entity_decode($item->title)!!}</a>
                                @endif
                                @endforeach
                                @else

                                @foreach ($button as $item)
                                @if ( $item->code == 'read')
                                <a href="{{ route('event-show', $event->id) }}"
                                   class="btn btn-outline-danger btn-block">{!!html_entity_decode($item->title)!!}</a>
                                @endif
                                @if ( $item->code == 'maps')
                                <a target="_blank" href="{{ $event->maps }}" class="btn btn-outline-dark btn-block">{!!html_entity_decode($item->title)!!}</a>
                                @endif
                                @endforeach

                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </section>

        </div>
    </section>
    <!-- End Features Section -->

</main>
<!-- End #main -->
@endsection
