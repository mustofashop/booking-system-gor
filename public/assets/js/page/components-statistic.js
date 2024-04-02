"use strict";

var ctx = document.getElementById("myChart2").getContext('2d');
var myChart = new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    datasets: [{
      label: 'Total',
      data: [460, 458, 330, 502, 430, 610, 488, 120, 150, 309, 230, 330],
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
          stepSize: 150
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