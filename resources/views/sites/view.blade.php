@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
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
                    <li class="list-group-item">Vote <a href="" class="btn btn-primary">Vote</a></li>
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
</div>
@endsection