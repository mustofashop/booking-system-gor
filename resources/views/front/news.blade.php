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
                @if ($item->code == 'news')
                <h2>{!!html_entity_decode($item->title)!!}</h2>
                <p>{!!html_entity_decode($item->desc)!!}</p>
                @endif
                @endforeach
            </div>

            <section class="container">
                <div class="events-container">
                    @foreach ($news as $item)
                    <div class="event">
                         {{-- Cek apakah gambar utama ada dan valid --}}
                    @if ($item->image && Storage::exists('public/news/' . $item->image))
                        <a href="{{ asset('storage/news/'. $item->image) }}" class="gallery-lightbox">
                            <img src="{{ asset('storage/news/' . $item->image) }}" class="img-thumbnail" width="200">
                        </a>
                    @endif
                
                    {{-- Cek apakah gambar kedua ada dan valid --}}
                    @if ($item->image2 && Storage::exists('public/news/' . $item->image2))
                        <a href="{{ asset('storage/news/'. $item->image2) }}" class="gallery-lightbox">
                            <img src="{{ asset('storage/news/' . $item->image2) }}" alt="Gambar 2">
                        </a>
                    @endif
                
                    {{-- Cek apakah gambar ketiga ada dan valid --}}
                    @if ($item->image3 && Storage::exists('public/news/' . $item->image3))
                        <a href="{{ asset('storage/news/'. $item->image3) }}" class="gallery-lightbox">
                            <img src="{{ asset('storage/news/' . $item->image3) }}" alt="Gambar 3">
                        </a>
                    @endif
                
                    {{-- Jika tidak ada gambar sama sekali, tampilkan gambar default --}}
                    @if (!$item->image && !$item->image2 && !$item->image3)
                        <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail" width="100">
                    @endif

                    <div class="event-details">
                        <div class="event-info">
                            <h3># <b> {{ $item->title }} </b> </h3>
                            
                        </div>
                        {{-- <div class="event-info">
                            <span> <b> {{ date('d F Y', strtotime($item->created_at)) }} </b> </span>
                        </div> --}}
                        <div class="event-description">
                            <span><i class="bi bi-journal-text"></i> {!! Str::words(html_entity_decode($item->desc), 50, ' ...') !!}</span>
                            <br>
                            <span><i class="bi bi-envelope"></i> {{ $item->email }}</span>
                            <br>
                            <span><i class="bi bi-telephone"></i> {{ $item->phone }}</span>
                            <br>
                            <span><i class="bi bi-geo-alt"></i> {{ $item->location }}</span>
                            <br>
                        </div>
                        {{-- <div class="event-buttons">
                            @foreach ($button as $item)
                            @if ( $item->code == 'more')
                            <a class="btn small btn-outline-dark margin-10px-top md-no-margin-top"
                                href="{{ route('news-show', $item->id) }}">
                                {!!html_entity_decode($item->title)!!} <i class="ri-arrow-right-s-line"></i></a>
                            @endif
                            @endforeach
                        </div> --}}
                        @foreach ($button as $item)
                        {{-- @if ($item->code == 'news') --}}
                        @if ( $item->code == 'order')
                        @if (Auth::check())
                        <a href="{{ route('booking.show', $item->id) }}"
                           class="btn btn-outline-success btn-block">{!!html_entity_decode($item->title)!!}</a>
                        @else
                        <a href="/register" class="btn btn-outline-success btn-block">{!!html_entity_decode($item->title)!!}</a>
                        @endif
                        @endif
                        @endforeach
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
