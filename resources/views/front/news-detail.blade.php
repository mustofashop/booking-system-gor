@extends('layout.details.default', ['title' => 'Event'])
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
                @foreach ($label as $item)
                @if ( $item->code == 'news')
                <h2>{{ $item->title }}</h2>
                <p>#{{ $item->desc }} , {{ $news->title }}</p>
                @endif
                @endforeach
                {{-- <div class="event-info">
                    <h3>{{ $event->location }}</h3>
                    <h3>{{ date('H:i', strtotime($event->time)) }}</h3>
                </div> --}}
            </div>

            <div class="events-container-detail">
                <div class="event" data-aos="zoom-in" data-aos-delay="100">
                    {{-- Cek apakah gambar utama ada dan valid --}}
                    @if ($news->image && Storage::exists('public/news/' . $news->image))
                        <a href="{{ asset('storage/news/'. $news->image) }}" class="gallery-lightbox">
                            <img src="{{ asset('storage/news/' . $news->image) }}" class="img-thumbnail" width="200">
                        </a>
                    @endif
                
                    {{-- Cek apakah gambar kedua ada dan valid --}}
                    @if ($news->image2 && Storage::exists('public/news/' . $news->image2))
                        <a href="{{ asset('storage/news/'. $news->image2) }}" class="gallery-lightbox">
                            <img src="{{ asset('storage/news/' . $news->image2) }}" alt="Gambar 2">
                        </a>
                    @endif
                
                    {{-- Cek apakah gambar ketiga ada dan valid --}}
                    @if ($news->image3 && Storage::exists('public/news/' . $news->image3))
                        <a href="{{ asset('storage/news/'. $news->image3) }}" class="gallery-lightbox">
                            <img src="{{ asset('storage/news/' . $news->image3) }}" alt="Gambar 3">
                        </a>
                    @endif
                
                    {{-- Jika tidak ada gambar sama sekali, tampilkan gambar default --}}
                    @if (!$news->image && !$news->image2 && !$news->image3)
                        <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail" width="100">
                    @endif
                </div>
                

                    <div class="event-details">
                        <div class="event-title">
                            <h3>{{ $news->title }}</h3>
                        </div>
                        <div class="event-body">
                            <table class="table table-borderless">
                                <tbody>
                                <tr>
                                    <td>
                                        <div class="badge badge-primary">{{ $news->organizer }}</div>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="event-description">
                            <p>{{ (strip_tags(html_entity_decode($news->desc))) }}
                                
                            </p>
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
