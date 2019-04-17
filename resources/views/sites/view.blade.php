@extends('layouts.app')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @if(session()->has('message'))
                <div class="alert alert-success">
                    <center><h3>{{ session()->get('message') }}</h3></center>
                </div>
            @endif
            <h1>{{ $site->title }}</h1>
        </div>
            <div class="col-md-4 mb-2">
                <div class="card">
                  <div class="card-header">
                    <b>Info</b>
                  </div>
                  <ul class="list-group list-group-flush">
                    <li class="list-group-item">Rank <b>#{{ $site->rank }}</b></li>
                    <li class="list-group-item">Website: <b><a href="{{ $site->url }}" class="btn btn-success">Visit</b></a></li>
                    <li class="list-group-item">Vote <a href="{{ URL::to('/vote/'.$site->id) }}" class="btn btn-primary">Vote</a></li>
                    <li class="list-group-item">Added By <b>{{ $user->name }}</b></li>
                    <li class="list-group-item">Added Day <b>{{ $site->created_at }}</b></li>
                    <li class="list-group-item">Last Update <b>{{ $site->updated_at }}</b></li>
                  </ul>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <img class="img-fluid" src="{{ URL::to('/') }}/images/header.jpg">
                        <h3 class="m-2">{{ $site->description }}</h3>
                </div>
            </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <canvas id="myChart" width="400" height="400"></canvas>
<script>
var ctx = document.getElementById('myChart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
        datasets: [{
            label: '# of Votes',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 206, 86, 0.2)',
                'rgba(75, 192, 192, 0.2)',
                'rgba(153, 102, 255, 0.2)',
                'rgba(255, 159, 64, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
</script>
        </div>
    </div>
</div>
@endsection