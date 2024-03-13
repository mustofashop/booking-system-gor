@extends('layout.default')
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

<style>
    .news-block {
        margin-bottom: 40px;
    }

    .news-block .col-md-4 {
        padding-right: 15px;
        padding-left: 15px;
    }

    .news-block .col-md-8 {
        padding-right: 15px;
        padding-left: 15px;
    }

    .news-block img {
        width: 100%;
        height: auto;
        display: block;
        border-radius: 5px;
    }

    .news-block h3 {
        font-size: 24px;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .news-block p {
        font-size: 14px;
        color: #777;
        margin-bottom: 15px;
    }

    .news-block span {
        font-size: 16px;
        color: #555;
        line-height: 1.6;
        display: block;
        margin-bottom: 15px;
    }

    .news-block a {
        font-size: 14px;
        color: #3d3d3d;
        text-decoration: none;
        background-color: #ffffff;
        padding: 8px 15px;
        border-radius: 5px;
        display: inline-block;
        transition: background-color 0.3s;
    }

    .news-block a:hover {
        background-color: #3D3D3DFF;
    }
</style>


<main id="main">

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero">
        <div class="container">
            <div class="row justify-content-center align-items-center" style="height: 60vh;">
                <div class="col-lg-12" data-aos="zoom-out">
                    @foreach ($label as $item)
                    @if ($item->code == 'hero')
                    <h1 style="color:#F0E701; text-align: center;">{!! html_entity_decode($item->title) !!}</h1>
                    <h2 style="color:#FFFFFF; text-align: center;">{!! html_entity_decode($item->desc) !!}</h2>
                    @endif
                    @endforeach
                    <div class="text-center mt-2">
                        @foreach ($button as $item)
                        @if ($item->code == 'register')
                        <a href="{!! html_entity_decode($item->url) !!}" class="btn-get-started scrollto">{!!
                            html_entity_decode($item->title) !!}</a>
                        @endif
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 order-lg-first" data-aos="zoom-out" data-aos-delay="300">
                    <!-- Your image here -->
                </div>
            </div>
        </div>

        <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
             viewBox="0 24 150 28 " preserveAspectRatio="none">
            <defs>
                <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z">
            </defs>
            <g class="wave1">
                <!-- rgba(240,231,1, .1) -->
                <use xlink:href="#wave-path" x="50" y="3" fill="#000000">
            </g>
            <g class="wave2">
                <use xlink:href="#wave-path" x="50" y="0" fill="rgba(255,255,255, .2)">
            </g>
            <g class="wave3">
                <use xlink:href="#wave-path" x="50" y="9" fill="#fff">
            </g>
        </svg>
    </section>
    <!-- End Hero -->

    <!-- ======= About Section ======= -->

    <!-- ======= About Section ======= -->
    <section id="history" class="about">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-5 col-lg-6 video-box d-flex justify-content-center align-items-stretch"
                     data-aos="fade-right">
                    @foreach ($button as $item)
                    @if ( $item->code == 'channel')
                    <a target="_blank" href="{!!html_entity_decode($item->url)!!}" class="glightbox play-btn mb-4"></a>
                    @endif
                    @endforeach
                </div>

                <div
                    class="col-xl-7 col-lg-6 icon-boxes d-flex flex-column align-items-stretch justify-content-center py-5 px-lg-5"
                    data-aos="fade-left">
                    @foreach ($label as $item)
                    @if ( $item->code == 'history')
                    <h3>{!!html_entity_decode($item->title)!!}</h3>
                    <p align="justify">{!!html_entity_decode($item->desc)!!}</p>
                    @endif
                    @endforeach

                    @foreach($historys as $value)
                    <div class="icon-box" data-aos="zoom-in" data-aos-delay="100">
                        <div class="icon"><i class="bx bx-{!!html_entity_decode($value->image)!!}"></i></div>
                        <h4 class="title"><a href="">{!!html_entity_decode($value->title)!!}</a></h4>
                        <p class="description">
                            {!! Str::words(html_entity_decode($value->desc), 25, ' ...') !!}
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- End About Section -->

    <!-- ======= Counts Section ======= -->
    <!--    <section id="count" class="counts">-->
    <!--        <div class="container">-->
    <!---->
    <!--            <div class="row" data-aos="fade-up">-->
    <!---->
    <!--                @foreach($about as $value)-->
    <!--                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">-->
    <!---->
    <!--                    <div class="count-box">-->
    <!--                        <i class="bi bi-{{ $value->image }}"></i>-->
    <!--                        <span data-purecounter-start="0" data-purecounter-end="{{ $value->count }}"-->
    <!--                              data-purecounter-duration="1" class="purecounter">-->
    <!--                        </span>-->
    <!--                        <p>++ {{ $value->title }}</p>-->
    <!--                    </div>-->
    <!---->
    <!--                </div>-->
    <!--                @endforeach-->
    <!---->
    <!--            </div>-->
    <!---->
    <!--        </div>-->
    <!--    </section>-->
    <!-- End Counts Section -->

    <!-- ======= Prosedur Section ======= -->
    <section id="event" class="features">
        <div class="container mt-5">

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
            @foreach ($button as $item)
            @if ( $item->code == 'more-event')
            <a href="{!!html_entity_decode($item->url)!!}" class="btn btn-outline-dark btn-block">{!!html_entity_decode($item->title)!!}</a>
            @endif
            @endforeach
        </div>
    </section>
    <!-- End Features Section -->

    <!-- ======= Details Section ======= -->
    <section id="news" class="details">
        <div class="container">
            <div class="section-title" data-aos="fade-up">
                @foreach ($label as $item)
                @if ( $item->code == 'news')
                <h2>{!!html_entity_decode($item->title)!!}</h2>
                <p>{!!html_entity_decode($item->desc)!!}</p>
                @endif
                @endforeach
            </div>

            @foreach($news as $value)
            <div class="row align-items-center news-block no-gutters" data-aos="fade-up">
                @if ( $value->id % 2 == 1)
                <div class="col-md-4">
                    <img src="{{ asset('storage/news/'. $value->image) }}" class="img-fluid" alt="">
                </div>
                <div class="col-md-8 pt-2">
                    <h3>{{ $value->title }}</h3>
                    <p>{{ date('d F Y H:i', strtotime($value->created_at)) }} | {{ strtoupper($value->created_by) }}</p>
                    <span>{{ Str::limit(html_entity_decode($value->desc), 500, '...') }}</span>
                    @foreach ($button as $item)
                    @if ( $item->code == 'more')
                    <a class="btn small btn-outline-dark margin-10px-top md-no-margin-top"
                       href="{{ route('news-show', $value->id) }}">
                        {!!html_entity_decode($item->title)!!} <i class="ri-arrow-right-s-line"></i></a>
                    @endif
                    @endforeach
                </div>
                @else
                <div class="col-md-8 pt-2">
                    <h3>{{ $value->title }}</h3>
                    <p>{{ date('d F Y H:i', strtotime($value->created_at)) }} | {{ strtoupper($value->created_by) }}</p>
                    <span>{{ Str::limit(html_entity_decode($value->desc), 500, '...') }}</span>
                    @foreach ($button as $item)
                    @if ( $item->code == 'more')
                    <a class="btn small btn-outline-dark margin-10px-top md-no-margin-top"
                       href="{{ route('news-show', $value->id) }}">
                        {!!html_entity_decode($item->title)!!} <i class="ri-arrow-right-s-line"></i></a>
                    @endif
                    @endforeach
                </div>
                <div class="col-md-4">
                    <img src="{{ asset('storage/news/'. $value->image) }}" class="img-fluid" alt="">
                </div>
                @endif
            </div>
            @endforeach
            @foreach ($button as $item)
            @if ( $item->code == 'more-news')
            <a href="{!!html_entity_decode($item->url)!!}" class="btn btn-outline-dark btn-block">{!!html_entity_decode($item->title)!!}</a>
            @endif
            @endforeach
        </div>
    </section>
    <!-- End Details Section -->

    <!-- ======= Gallery Section ======= -->
    <section id="gallery" class="gallery">
        <div class="container">

            <div class="section-title" data-aos="fade-up">
                @foreach ($label as $item)
                @if ( $item->code == 'gallery')
                <h2>{!!html_entity_decode($item->title)!!}</h2>
                <p>{!!html_entity_decode($item->desc)!!}</p>
                @endif
                @endforeach
            </div>

            <div class="row g-0" data-aos="fade-left">

                @foreach($gallery as $value)
                <div class="col-lg-3 col-md-4">
                    <div class="gallery-item" data-aos="zoom-in" data-aos-delay="100">
                        <a href="{{ asset('storage/gallery/'. $value->image) }}" class="gallery-lightbox">
                            <img src="{{ asset('storage/gallery/'. $value->image) }}" alt="" class="img-fluid">
                        </a>
                    </div>
                </div>
                @endforeach

            </div>

        </div>
    </section>
    <!-- End Gallery Section -->

    <!-- ======= Team Section ======= -->
    <section id="team" class="team">
        <div class="container mt-5">

            <div class="section-title" data-aos="fade-up">
                @foreach ($label as $item)
                @if ( $item->code == 'team')
                <h2>{!!html_entity_decode($item->title)!!}</h2>
                <p>{!!html_entity_decode($item->desc)!!}</p>
                @endif
                @endforeach

                @foreach ($label as $item)
                @if ( $item->code == 'top.four')
                <span title="{!!html_entity_decode($item->desc)!!}">
                <i class="bi bi-award-fill"></i>
                    {!!html_entity_decode($item->title)!!}
                </span>
                @endif
                @endforeach
            </div>

            <div class="row" data-aos="fade-left">

                @foreach($team as $value)
                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="member" data-aos="zoom-in" data-aos-delay="300">
                        <div class="pic">
                            @if($value->image && Storage::exists('public/team/' . $value->image))
                            <img src="{{ asset('storage/team/'. $value->image) }}" class="img-fluid" alt="">
                            @else
                            <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-fluid" alt="">
                            @endif
                        </div>
                        <div class="member-info">
                            <h4>{{ $value->name }}</h4>
                            <span>{{ $value->place }}, {{ date('d F Y', strtotime($value->date)) }}</span>
                            <h2>
                                <i class="bi bi-award"></i> {{ $value->point[0]->total_point }}
                            </h2>
                            <div class="social m-3">
                                @foreach ($button as $item)
                                @if ( $item->code == 'point')
                                <a href="{{ route('point-show', $value->id) }}"
                                   class="btn btn-outline-danger btn-block mt-1">{!!html_entity_decode($item->title)!!}</a>
                                @endif
                                @endforeach
                                <!-- <a href="{{ $value->instagram }}"><i class="bi bi-instagram"></i></a> -->
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            @foreach ($button as $item)
            @if ( $item->code == 'more-rider')
            <a href="{!!html_entity_decode($item->url)!!}" class="btn btn-outline-dark btn-block mt-3">{!!html_entity_decode($item->title)!!}</a>
            @endif
            @endforeach
        </div>
    </section>
    <!-- End Team Section -->

    <!-- ======= F.A.Q Section ======= -->
    <section id="faq" class="faq section-bg">
        <div class="container">

            <div class="section-title" data-aos="fade-up">
                @foreach ($label as $item)
                @if ( $item->code == 'faq')
                <h2>{!!html_entity_decode($item->title)!!}</h2>
                <p>{!!html_entity_decode($item->desc)!!}</p>
                @endif
                @endforeach
            </div>

            <div class="faq-list">
                <ul>
                    @foreach($question as $value)
                    <li data-aos="fade-up" data-aos-delay="100">
                        <i class="bx bx-help-circle icon-help"></i> <a data-bs-toggle="collapse" class="collapse"
                                                                       data-bs-target="#faq-list-{{ $value->id }}"> {{
                            $value->question }} <i class="bx bx-chevron-down icon-show"></i><i
                                class="bx bx-chevron-up icon-close"></i></a>
                        <div id="faq-list-{{ $value->id }}" class="collapse" data-bs-parent=".faq-list">
                            <p>
                                {!!html_entity_decode($value->answer)!!}
                            </p>
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    <!-- End F.A.Q Section -->

    <!-- ======= Testimonials Section ======= -->
    <section id="testimonials" class="testimonials">
        <div class="container">

            <div class="testimonials-slider swiper" data-aos="fade-up" data-aos-delay="100">
                <div class="swiper-wrapper">

                    @foreach($testimonial as $value)
                    <div class="swiper-slide">
                        <div class="testimonial-item">
                            <img src="{{ asset('storage/testimoni/'. $value->image) }}" class="testimonial-img" alt=""
                                 style="width: 100px; height: 100px;">
                            <h3>{{ $value->name }}</h3>
                            <h4>{{ $value->position }}</h4>
                            <p>
                                <i class="bx bxs-quote-alt-left quote-icon-left"></i>
                                {!!html_entity_decode($value->desc)!!}
                                <i class="bx bxs-quote-alt-right quote-icon-right"></i>
                            </p>
                        </div>
                    </div>
                    <!-- End testimonial item -->
                    @endforeach

                </div>
                <div class="swiper-pagination"></div>
            </div>

        </div>
    </section>
    <!-- End Testimonials Section -->

</main>
<!-- End #main -->
@endsection
