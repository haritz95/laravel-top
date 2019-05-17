@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-12">
        @if(session()->has('message'))
                <div class="alert alert-danger">
                    <center><h3>{{ session()->get('message') }}</h3></center>
                </div>
            @endif
      </div>
        <div class="col-md-12 d-flex justify-content-center">
            <form action="{{ url('/vote/add/'.$site->id) }}" method="POST" style="width: 25rem; border: solid 1px;">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-group">
                <center><h1>{{ $site->title }}</h1></center>
                <input type="hidden" name="site_id" value="">
              </div>
                  <center><div class="col-md-12 mb-2">
                    {!! NoCaptcha::display() !!}
                      @if ($errors->has('g-recaptcha-response'))
                        <div class="error mb-2"><strong style="color: red">{{ $errors->first('g-recaptcha-response') }}</strong></div>
                      @endif
                  </div></center>
              <center><button type="submit" class="btn btn-primary mb-2">Vote</button></center>
            </form>
        </div>
    </div>
</div>
@endsection