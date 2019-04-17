@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            @foreach($sites as $site)
            @if($site->premium === 1)
                <div class="row test" style="background-color: #f3eed8">
            @else
                <div class="row test">
            @endif
                <div class="col-md-2 text-center">
                    <h1>Rank</h1>
                    <h1 class="center">{{ $site->rank }}</h1>
                </div>
                <div class="col-md-8 text-center">
                    <h4><a href="{{ route('sites.show', $site->id) }}" class="server-title">{{ $site->title }}</a></h4>
                    <center><a href="{{ route('sites.show', $site->id) }}"><img style="width: 468; height: 60;" class="img-fluid" src="{{ $site->url_file }}"></a></center>
                    <h7>{{ $site->description }}</h7>
                </div>
                <div class="col-md-2 text-center">
                    <h1>Votes</h1>
                    <h1 class="center">{{ $site->votes }}</h1>
                </div>
            </div>
            @endforeach
            {{ $sites->links() }}
        </div>
    </div>
</div>
@endsection