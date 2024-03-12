@extends('layout.details.default', ['title' => 'Point Detail'])
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

    <!-- ======= Point Section ======= -->
    <section id="team" class="team">
        <div class="container mt-5">
            <div class="row">
                <div class="col-lg-6 col-md-6 mt-5">
                    <div class="member" data-aos="zoom-in" data-aos-delay="300">
                        <div class="pic">
                            @if($member->image && Storage::exists('public/team/' . $member->image))
                            <img src="{{ asset('storage/team/'. $member->image) }}" class="img-fluid" alt="">
                            @else
                            <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-fluid" alt="">
                            @endif
                        </div>
                        <div class="member-info">
                            <span>
                                <div class="badge bg-dark">
                                {{ $member->code }}
                                </div>
                                /
                                <i class="bi bi-bicycle"></i>
                                {{ $member->number_booking }}
                            </span>
                            <h2>{{ $member->name }}</h2>
                            <span>
                                <a href=" {{ $member->socmed }}"><i class="bi bi-instagram"></i></a>
                                #{{ $member->nickname }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 mt-5">
                    <div class="m-3" data-aos="zoom-in" data-aos-delay="300">
                        <span><i class="bi bi-person"></i>
                            @if ($member->gender == 'L')
                            Boy
                            @else
                            Girl
                            @endif
                        </span>
                        <br>
                        <span><i class="bi bi-map"></i> {{ $member->place }}, {{ date('d F Y', strtotime($member->date)) }}</span>
                        <br>
                        <span><i class="bi bi-envelope"></i> {{ $member->email }}</span>
                        <br>
                        <span><i class="bi bi-telephone"></i> {{ $member->phone }}</span>
                        <br>
                        <span><i class="bi bi-geo-alt"></i> {{ $member->address }}</span>
                        <div class="social m-3">
                            <h5>{{ $member->height }}CM / {{ $member->weight }}KG</h5>
                        </div>
                        <div class="section-title" data-aos="fade-up">
                            @foreach ($label as $item)
                            @if ( $item->code == 'race')
                            <h2>{!!html_entity_decode($item->title)!!}</h2>
                            <p>{!!html_entity_decode($item->desc)!!}</p>
                            @endif
                            @endforeach
                        </div>
                        <h5>{{ $member->point[0]->event->title }}</h5>
                        <div class="social m-3">
                            <div class="row">
                                <div class="col-lg-4 col-md-4">
                                    <i class="bi bi-award-fill"></i> POINT
                                    <h2>{{ $member->point[0]->total_point }}</h2>
                                </div>
                                <div class="col-lg-4 col-md-4">
                                    <i class="bi bi-award"></i> RANK
                                    <h2>{{ $member->point[0]->rank }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="section-title" data-aos="fade-up">
                            <span>#{{ $member->point[0]->event->code }} , {{ date('d F Y',
                                strtotime($member->point[0]->event->date)) }}</span>
                            <div class="event-info">
                                <span>{{ $member->point[0]->event->location }}</span>
                                <span>{{ date('H:i', strtotime($member->point[0]->event->time)) }}</span>
                            </div>
                            <span>{{ $member->point[0]->event->description }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @foreach ($button as $item)
            @if ( $item->code == 'more-rider')
            <a href="{!!html_entity_decode($item->url)!!}" class="btn btn-outline-dark btn-block mt-3">{!!html_entity_decode($item->title)!!}</a>
            @endif
            @endforeach
        </div>
    </section>
    <!-- End Point Section -->


</main>
<!-- End #main -->
@endsection
