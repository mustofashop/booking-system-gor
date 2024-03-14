@extends('layout.dashboard.app', ['title' => 'Calendar'])
@section('content')

<style>
    .calendar-container {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .calendar-item {
        flex: 1 1 calc(33.33% - 20px);
        border: 1px solid #ccc;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
        display: flex;
    }

    .calendar-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    .calendar-item img {
        width: 200px;
        height: 100%;
        object-fit: cover;
        border-bottom: 1px solid #ddd;
    }

    .calendar-details {
        flex: 1;
        padding: 20px;
    }

    .calendar-details h3 {
        margin: 0;
        font-size: 1.2rem;
        color: #333;
        margin-bottom: 10px;
    }

    .calendar-details p {
        margin: 0;
        font-size: 0.9rem;
        color: #555;
        margin-bottom: 8px;
    }

    .calendar-action {
        margin-top: auto; /* Untuk menjaga tombol aksi tetap di bagian bawah */
    }

    .calendar-action .btn {
        font-size: 14px;
    }
</style>

@section('content')
<section class="section">
    @foreach ($label as $item)
    @if ($item->code == 'calendar')
    <div class="section-title">
        <h3>{!! html_entity_decode($item->title) !!}</h3>
    </div>
    <p class="section-lead">
        {!! html_entity_decode($item->desc) !!}
    </p>
    @endif
    @endforeach

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>List</h4>
                    <div class="card-header-action">
                        <a href="{{ route('event.index') }}" class="btn btn-warning" data-toggle="tooltip"
                           title="Back"><i class="fas fa-backward"></i></a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row" data-aos="fade-up" data-aos-delay="100">
                        <div class="col-lg-12 mt-4 mt-lg-0">
                            <form action="{{ route('event.calendar') }}" method="GET">
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
                    <div class="calendar-container">
                        @forelse ($events as $calendar)
                        <div class="calendar-item" data-aos="fade-up">
                            <div class="calendar-content">
                                @if ($calendar->image && Storage::exists('public/event/' . $calendar->image))
                                <a href="{{ asset('storage/event/'. $calendar->image) }}" target="_blank">
                                    <img src="{{ asset('storage/event/'. $calendar->image) }}"
                                         alt="{{ $calendar->title }}">
                                </a>
                                @else
                                <img src="{{ asset('assets/img/default-image.jpg') }}" alt="{{ $calendar->title }}">
                                @endif
                            </div>
                            <div class="calendar-details">
                                <h3>{{ $calendar->title }}</h3>
                                <p><strong>{{ date('d F Y', strtotime($calendar->date)) }}</strong></p>
                                <b><i class="bx bx-time"></i> {{ date('H:i', strtotime($calendar->time)) }}</b>
                                <p><i class="bx bx-map"></i> {{ $calendar->location }}</p>
                                <p><i class="bx bx-building-house"></i> {{ $calendar->organizer ?? 'Unknown' }}</p>
                                <div class="calendar-action">
                                    <!--                                    <a href="{{ route('calendar-show', $calendar->id) }}"-->
                                    <!--                                       class="btn btn-outline-dark btn-block">View</a>-->
                                </div>
                            </div>
                        </div>
                        @empty
                        <div class="col-md-12">
                            <div class="alert alert-danger" role="alert">
                                No Data Found
                            </div>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
