@extends('layout.details.default', ['title' => 'Rider'])
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

    <!-- ======= Team Section ======= -->
    <section id="team" class="team">
        <div class="container mt-5">

            <div class="section-title" data-aos="fade-up">
                @foreach ($label as $item)
                @if ( $item->code == 'rider.all')
                <h2>{!!html_entity_decode($item->title)!!}</h2>
                <p>{!!html_entity_decode($item->desc)!!}</p>
                @endif
                @endforeach
            </div>

            <div class="row" data-aos="fade-left">

                @foreach($team as $value)
                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="row m-3 text-center">
                        <div class="col-lg-6 col-md-4">
                            <i class="bi bi-award-fill"></i> POINT
                            <h2>{{ $value->point[0]->total_point }}</h2>
                        </div>
                        <div class="col-lg-6 col-md-4">
                            <i class="bi bi-award"></i> RANK
                            <h2>{{ $value->point[0]->rank }}</h2>
                        </div>
                    </div>
                    <div class="member" data-aos="zoom-in" data-aos-delay="300">
                        <div class="pic">
                            @if($value->image && Storage::exists('public/rider/' . $value->image))
                            <img src="{{ asset('storage/rider/'. $value->image) }}" class="img-fluid" alt="">
                            @else
                            <img src="{{ asset('assets/img/avatar/avatar-5.png') }}" class="img-fluid" alt="">
                            @endif
                        </div>
                        <div class="member-info">
                            <h4>{{ $value->name }}</h4>
                            <span>{{ $value->place }}, {{ date('d F Y', strtotime($value->date)) }}</span>
                            <div class="social m-3">
                                @foreach ($button as $item)
                                @if ( $item->code == 'more')
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
        </div>
    </section>
    <!-- End Team Section -->

</main>
<!-- End #main -->
@endsection
