@extends('layout.dashboard.app', ['title' => 'E-Event - Dashboard'])

@section('content')
    @include('layout.dashboard.partials.alert')
    <div class="container-fluid">
        <div class="row text-center">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card card-statistic-2">
                            <div class="card-stats">
                                <div class="card-stats-title">Order Statistics -
                                    <div class="dropdown d-inline">
                                        <form action="{{ route('dashboard.home') }}" method="GET">
                                            <div class="input-group mb-3">
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
                                <div class="card-stats-items">
                                    <div class="card-stats-item">
                                        <div class="card-stats-item-count">24</div>
                                        <div class="card-stats-item-label">Pending</div>
                                    </div>
                                    <div class="card-stats-item">
                                        <div class="card-stats-item-count">12</div>
                                        <div class="card-stats-item-label">Shipping</div>
                                    </div>
                                    <div class="card-stats-item">
                                        <div class="card-stats-item-count">23</div>
                                        <div class="card-stats-item-label">Completed</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-icon shadow-primary bg-primary">
                                <i class="fas fa-archive"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Orders</h4>
                                </div>
                                <div class="card-body">
                                    59
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-12">
                        <div class="card card-statistic-2">
                            <div class="card-stats">
                                <div class="card-stats-title">Income Statistics -
                                    <div class="dropdown d-inline">
                                        <form action="{{ route('dashboard.home') }}" method="GET">
                                            <div class="input-group mb-3">
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
                                <div class="card-stats-items">
                                    <div class="card-stats-item">
                                        <div class="card-stats-item-count">24</div>
                                        <div class="card-stats-item-label">Pending</div>
                                    </div>
                                    <div class="card-stats-item">
                                        <div class="card-stats-item-count">12</div>
                                        <div class="card-stats-item-label">Shipping</div>
                                    </div>
                                    <div class="card-stats-item">
                                        <div class="card-stats-item-count">23</div>
                                        <div class="card-stats-item-label">Completed</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-icon shadow-primary bg-primary">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="card-header">
                                    <h4>Total Income</h4>
                                </div>
                                <div class="card-body">
                                    $187,13
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{ asset('assets/js/chart.min.js') }}"></script>
        <script>
            var ctx = document.getElementById("myChart2").getContext('2d');
            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                    datasets: [{
                        label: 'Total Events',
                        data: [{{ $total1 }}, {{ $total2 }}, {{ $total3 }},
                            {{ $total4 }}, {{ $total5 }}, {{ $total6 }},
                            {{ $total7 }}, {{ $total8 }}, {{ $total9 }},
                            {{ $total10 }}, {{ $total11 }}, {{ $total12 }}
                        ],
                        borderWidth: 2,
                        backgroundColor: 'rgba(63,82,227,.8)',
                        borderColor: 'rgba(63,82,227,.8)',
                        borderWidth: 2.5,
                        pointBackgroundColor: '#ffffff',
                        pointRadius: 4
                    }]
                },
                options: {
                    legend: {
                        display: false
                    },
                    scales: {
                        yAxes: [{
                            gridLines: {
                                drawBorder: false,
                                color: '#f2f2f2',
                            },
                            ticks: {
                                beginAtZero: true,
                                stepSize: 30
                            }
                        }],
                        xAxes: [{
                            gridLines: {
                                display: false
                            }
                        }]
                    },
                }
            });
        </script>
    @endsection
