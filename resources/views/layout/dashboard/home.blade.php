@extends('layout.dashboard.app', ['title' => 'E-Event - Dashboard'])

@section('content')
@include('layout.dashboard.partials.alert')
<div class="container-fluid">
    <div class="row text-center">
        <div class="col-sm-12">
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
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-12">
                    <div class="card card-statistic-2">
                        <div class="card-stats">
                            <div class="card-stats-title">

                            </div>
                            <div class="card-stats-items">
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $events }}</div>
                                    <div class="card-stats-item-label">Total Events</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $bookings }}</div>
                                    <div class="card-stats-item-label">Total Booking</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $members }}</div>
                                    <div class="card-stats-item-label">Total Riders</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $users }}</div>
                                    <div class="card-stats-item-label">Total Users</div>
                                </div>
                                <div class="card-stats-item">
                                    <div class="card-stats-item-count">{{ $articles }}</div>
                                    <div class="card-stats-item-label">Total Article</div>
                                </div>
                            </div>
                        </div>
                        <div class="card-wrap">
                        </div>
                        <hr>
                        <div class="card">
                            <div class="card-header">
                              <h4>Events</h4>
                            </div>
                            <br>
                            <div class="card-body"><div style="position: absolute; inset: 0px; overflow: hidden; pointer-events: none; visibility: hidden; z-index: -1;" class="chartjs-size-monitor"><div class="chartjs-size-monitor-expand" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:1000000px;height:1000000px;left:0;top:0"></div></div><div class="chartjs-size-monitor-shrink" style="position:absolute;left:0;top:0;right:0;bottom:0;overflow:hidden;pointer-events:none;visibility:hidden;z-index:-1;"><div style="position:absolute;width:200%;height:200%;left:0; top:0"></div></div></div>
                              <canvas id="myChart2" height="277" style="display: block; width: 463px; height: 277px;" width="463" class="chartjs-render-monitor"></canvas>
                              <div class="statistic-details mt-1">
                              </div>
                            </div>
                          </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-12">
                  <div class="card gradient-bottom">
                    <div class="card-header">
                      <h4>Top 5 Riders</h4>
                    </div>
                    <div class="card-body" id="top-5-scroll" style="height: 315px; overflow: hidden; outline: none;" tabindex="2">
                        <ul class="list-unstyled list-unstyled-border">
                          @forelse ($point as $item)
                          <li class="media">
                            <img class="mr-3 rounded" width="55" src="{{ $item->member->image }}" alt="Photo">
                            <div class="media-body">
                              <div class="float-center"><div class="font-weight-600 text-muted text-small"></div></div>
                              <div class="media-title">{{ $item->member->name }}</div>
                              <div class="mt-1">
                                <div class="budget-price">
                                  <div class="budget-price-label">{{ $item->member->code }}</div>
                                </div>
                                <div class="budget-price">
                                  <div class="budget-price-label">Points : </div>
                                  <div class="budget-price-label">{{ $item->total_point }}</div>
                                </div>
                              </div>
                            </div>
                          </li>
                          @empty
                          <div class="media-body">
                            Data not available
                          </div>
                          @endforelse
                        </ul>
                      </div>
                      <div class="card-footer pt-3 d-flex justify-content-center">

                      </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12">
                
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
          data: [{{$total1}}, {{$total2}}, {{$total3}}, {{$total4}}, {{$total5}}, {{$total6}}, {{$total7}}, {{$total8}}, {{$total9}}, {{$total10}}, {{$total11}}, {{$total12}}],
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