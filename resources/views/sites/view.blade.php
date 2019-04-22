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
                    <li class="list-group-item">Website: <b><a href="{{ $site->url }}" class="btn btn-success" id="visit" target="_blank">Visit</b></a></li>
                    <li class="list-group-item">Vote <a href="{{ URL::to('/vote/'.$site->id) }}" class="btn btn-primary">Vote</a></li>
                    <li class="list-group-item">Added By <b>{{ $user->name }}</b></li>
                    <li class="list-group-item">Added Day <b>{{ $site->created_at }}</b></li>
                    <li class="list-group-item">Last Update <b>{{ $site->updated_at }}</b></li>
                  </ul>
                </div>
                <div style="width:100%;" class="mt-2">
                    <div class="card">
                        <div class="card-header">
                            <b>Stadistics</b>
                        </div>
                        {!! $chartjs->render() !!}
                    </div>
            </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <img class="img-fluid" src="{{ URL::to('/') }}/images/header.jpg">
                        <span class="m-2">{!! $site->p_description !!}</span>
                </div>
            </div>
    </div>
</div>
@endsection