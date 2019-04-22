@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="row test">
                <div class="col-md-2 text-center">
                    <h1>Rank</h1>
                    <h1 class="center">-</h1>
                </div>
                <div class="col-md-8 text-center">
                    <h4><a href="http://top.test/" class="server-title">AD</a></h4>
                    <center><a href="http://top.test/"><img style="width: 468; height: 60;" class="img-fluid" src="http://top.test/images/ad.jpg">
                    </a></center>
                    <h7>AD</h7>
                </div>
                <div class="col-md-2 text-center">
                    <h1>Votes</h1>
                    <h1 class="center">-</h1>
                </div>
            </div>
            <hr>
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
                    @if($site->premium === 1)
                    <center><a href="{{ route('sites.show', $site->id) }}"><img style="width: 468px; height: 60px;" class="img-fluid" src="{{ URL::to('/')."/".$site->url_file }}">
                    </a></center>
                    @else
                    @endif
                    <h7>{{ $site->description }}</h7>
                    <br>
                    @if($site->tags != "")
                    @foreach(explode(',', $site->tags) as $tag) 
                        <span class="badge badge-pill badge-danger mb-1" style="font-size: 0.8vw;">{{ $tag }}</span>
                    @endforeach
                    @endif
                    
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