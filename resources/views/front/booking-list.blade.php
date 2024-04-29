@extends('layout.details.default', ['title' => 'Standing'])
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
        <form action="{{ route('booking-list') }}" method="GET">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <div class="input-group input-group-sm mb-3">
                        <select class="form-select" id="search" name="search">
                            <option value="">-- Choose --</option>
                            @forelse ($event as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="submit">Search</button>
                        </div>
                    </div>
                    <table class="table table-striped mb-0">
                        <thead>
                        <tr style="text-align:left">
                            <th>NO RIDERS</th>
                            <th>PHOTO RIDERS</th>
                            <th>NAME</th>
                            <th>NATIONAL</th>
                            <th>COMUNITY</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($member as $item)
                        <tr>
                            <td>
                                <div class="badge badge-dark">{{ $item->number_plat }}</div>
                            </td>
                            <td>
                                @if ($item->image && Storage::exists('public/rider/' . $item->image))
                                <img src="{{ asset('storage/rider/' . $item->image) }}" class="img-thumbnail"
                                        width="100">
                                @else
                                <img src="{{ asset('assets/img/default-image.jpg') }}" class="img-thumbnail"
                                        width="100">
                                @endif
                            </td>
                            <td>
                                <i class="bx bxs-user"></i> {{ $item->user->name }}
                            </td>
                            <td>
                                <i class="bx bxs-flag"></i> {{ $item->nations->name }}
                            </td>
                            <td>
                                <i class="bx bxs-buildings"></i> {{ $item->event_id == null ? 'No Comunity' : $item->event->organizer}}
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
        </form>
            <div class="d-felx justify-content-center">
                <div class="card-footer text-right">
                    {{ $data->links('vendor.pagination.bootstrap-5') }}
                </div>
            </div>
    </section>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>
    <script>
        $(document).ready(function() {
            $('#search').select2();
        });
    </script>
@endsection