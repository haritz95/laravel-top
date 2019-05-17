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
            
            @if($site->status['name'] == "Pending")
                <div class="alert alert-warning">
                    <center><h3>This site is not active yet. Only you can see it.</h3></center>
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
                    <li class="list-group-item">Votes <b>{{ $site->votes }}</b></li>
                    <li class="list-group-item">Website: <b><a href="{{ $site->url }}" class="btn btn-success" id="visit" target="_blank">Visit</b></a></li>
                    <li class="list-group-item">Vote <a href="@if($site->status_id == 1){{ URL::to('/vote/'.$site->id) }}@else #  @endif" class="btn btn-primary">Vote</a></li>
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
                    <center><img class="img-fluid mt-2" src="{{$site->category['image']}}" width="350px" height="150px"></center>
                    <hr>
                    @if($site->user['premium'] == 1)
                        <span class="m-2">{!! $site->p_description !!}</span>
                    @else
                        <h1 class="m-2">{{ $site->description }}</h1>
                    @endif    
                </div>
            </div>
    </div>
</div>
@endsection