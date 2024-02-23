@extends('layout.default')
@section('content')

<main id="main">

    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero">

        <div class="container">
            <div class="row justify-content-between">
                <div class="col-lg-7 pt-5 pt-lg-0 order-2 order-lg-1 d-flex align-items-center">
                    <div data-aos="zoom-out">
                        @foreach ($label as $item)
                        @if ( $item->code == 'hero')
                        <h1 style="color:#F0E701;">{!!html_entity_decode($item->title)!!}</h1>
                        <h2 style="color:#FFFFFF;">{!!html_entity_decode($item->desc)!!}</h2>
                        @endif
                        @endforeach
                        <div class="text-center text-lg-start">
                            @foreach ($button as $item)
                            @if ( $item->code == 'register')
                            <a href="{!!html_entity_decode($item->url)!!}" class="btn-get-started scrollto">{!!html_entity_decode($item->title)!!}</a>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 order-1 order-lg-2 hero-img" data-aos="zoom-out" data-aos-delay="300">
                    <!--                    @foreach ($image as $item)-->
                    <!--                    @if ( $item->code == 'hero')-->
                    <!--                    <img class="img-fluid animated" src="{{ asset('storage/image/'. $item->image) }}">-->
                    <!--                    @endif-->
                    <!--                    @endforeach-->
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
                        <p class="description">{!! Str::words(html_entity_decode($value->desc), 25, ' ...') !!}</p>
                    </div>
                    @endforeach

                </div>
            </div>

        </div>
    </section>
    <!-- End About Section -->

    <!-- ======= Counts Section ======= -->
    <section id="count" class="counts">
        <div class="container">

            <div class="row" data-aos="fade-up">

                @foreach($about as $value)
                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">

                    <div class="count-box">
                        <i class="bi bi-{{ $value->image }}"></i>
                        <span data-purecounter-start="0" data-purecounter-end="{{ $value->count }}"
                              data-purecounter-duration="1" class="purecounter">
                        </span>
                        <p>++ {{ $value->title }}</p>
                    </div>

                </div>
                @endforeach

            </div>

        </div>
    </section>
    <!-- End Counts Section -->

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
                <div class="row" data-aos="fade-left">
                    <div class="col">
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                @foreach($event as $value)
                                <tr>
                                    <td rowspan="4" style="vertical-align: middle;">
                                        <a href="{{ asset('storage/event/'. $value->image) }}" target="_blank">
                                            <img src="{{ asset('storage/event/'. $value->image) }}"
                                                 class="img-thumbnail" alt=""
                                                 style="max-width: 200px; max-height: 200px;">
                                        </a>
                                    </td>
                                    <td><strong>#{{$loop->iteration}}</strong></td>
                                    <td><span>{{ date('d F Y', strtotime($value->date)) }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>{{ $value->title }}</strong></td>
                                    <td><i class="fas fa-map-marker-alt"></i> <span>{{ $value->location }}</span><br>
                                        <i class="fas fa-clock"></i> <span>{{ $value->time }}</span></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <small> {!! Str::words(html_entity_decode($value->description), 70, ' ...')
                                            !!}</small>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <strong style="color:
        @if($value->status == 'ACTIVE')
            green; /* Set the color to green for 'ACTIVE' status */
        @elseif($value->status == 'INACTIVE')
            red; /* Set the color to red for 'INACTIVE' status */
        @else
            black; /* Set the color to black for other statuses */
        @endif
    ">
                                            @if($value->status == 'ACTIVE')
                                            <span>OPEN</span>
                                            @elseif($value->status == 'INACTIVE')
                                            <span>CLOSE</span>
                                            @else
                                            {{ $value->status }}
                                            @endif
                                        </strong>
                                    </td>

                                    <td>
                                        @if($value->status == 'ACTIVE')

                                        @foreach ($button as $item)
                                        @if ( $item->code == 'read')
                                        <a href="#" class="btn btn-outline-danger btn-block">{!!html_entity_decode($item->title)!!}</a>
                                        @endif
                                        @if ( $item->code == 'order')
                                        <a href="#" class="btn btn-outline-success btn-block">{!!html_entity_decode($item->title)!!}</a>
                                        @endif
                                        @endforeach

                                        @elseif($value->status == 'INACTIVE')

                                        @foreach ($button as $item)
                                        @if ( $item->code == 'read')
                                        <a href="#" class="btn btn-outline-danger btn-block">{!!html_entity_decode($item->title)!!}</a>
                                        @endif
                                        @endforeach
                                        @else

                                        @foreach ($button as $item)
                                        @if ( $item->code == 'read')
                                        <a href="#" class="btn btn-outline-danger btn-block">{!!html_entity_decode($item->title)!!}</a>
                                        @endif
                                        @endforeach

                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </section>

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

            <div class="row align-items-center event-block no-gutters margin-40px-bottom">
                @foreach($news as $value)
                @if ( $value->id % 2 == 1)
                <div class="col-md-4" data-aos="fade-right">
                    <img src="{{ asset('storage/news/'. $value->image) }}" class="img-fluid" alt="">
                </div>
                <div class="col-md-8 pt-4" data-aos="fade-up">
                    <h3>{{ $value->title }}</h3>
                    <p>{{ $value->created_at }}</p>
                    <span style="text-align: justify; text-justify: distribute-all-lines;">
                        {{ Str::limit(html_entity_decode($value->desc), 500, '...') }}
                    </span>
                    @foreach ($button as $item)
                    @if ( $item->code == 'more')
                    <a class="butn small margin-10px-top md-no-margin-top" href="{!!html_entity_decode($item->url)!!}">
                        {!!html_entity_decode($item->title)!!} <i class="ri-arrow-right-s-line"></i></a>
                    @endif
                    @endforeach
                </div>
                @endif
                @endforeach
            </div>

            <div class="row align-items-center event-block no-gutters margin-40px-bottom">
                @foreach($news as $value)
                @if ( $value->id % 2 == 0)
                <div class="col-md-4" data-aos="fade-left">
                    <img src="{{ asset('storage/news/'. $value->image) }}" class="img-fluid" alt="">
                </div>
                <div class="col-md-8 pt-4 order-2 order-md-1" data-aos="fade-up">
                    <h3>{{ $value->title }}</h3>
                    <p>{{ $value->created_at }}</p>
                    <span style="text-align: justify; text-justify: distribute-all-lines;">
                        {{ Str::limit(html_entity_decode($value->desc), 500, '...') }}
                    </span>
                    @foreach ($button as $item)
                    @if ( $item->code == 'more')
                    <a class="butn small margin-10px-top md-no-margin-top" href="{!!html_entity_decode($item->url)!!}">
                        {!!html_entity_decode($item->title)!!} <i class="ri-arrow-right-s-line"></i></a>
                    @endif
                    @endforeach
                </div>
                @endif
                @endforeach
            </div>

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
        <div class="container">

            <div class="section-title" data-aos="fade-up">
                @foreach ($label as $item)
                @if ( $item->code == 'team')
                <h2>{!!html_entity_decode($item->title)!!}</h2>
                <p>{!!html_entity_decode($item->desc)!!}</p>
                @endif
                @endforeach
            </div>

            <div class="row" data-aos="fade-left">

                @foreach($team as $value)
                <div class="col-lg-3 col-md-6 mt-5 mt-lg-0">
                    <div class="member" data-aos="zoom-in" data-aos-delay="300">
                        <div class="pic"><img src="{{ asset('storage/team/'. $value->image) }}" class="img-fluid"
                                              alt=""></div>
                        <div class="member-info">
                            <h4>{{ $value->name }}</h4>
                            <span>{{ $value->place }}, {{ date('d F Y', strtotime($value->date)) }}</span>
                            <span>
                                @if($value->gender === 'L')
                                <i class="bi bi-person-standing"></i>
                                @elseif($value->gender === 'P')
                                <i class="bi bi-person-standing-dress"></i>
                                @endif
                            </span>
                            <div class="social">
                                @foreach ($button as $item)
                                @if ( $item->code == 'point')
                                <a href="{!!html_entity_decode($item->url)!!}" class="btn btn-outline-danger btn-block">{!!html_entity_decode($item->title)!!}</a>
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
