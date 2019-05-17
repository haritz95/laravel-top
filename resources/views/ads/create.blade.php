@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="alert alert-success" id="ad_info" role="alert" style="display: none;"></div>
            <div>
              {{ Breadcrumbs::render('create_ad') }}
            </div>
            @if(session()->has('message'))
                <div class="alert alert-success">
                    <center><h3>{{ session()->get('message') }}</h3></center>
                </div>
            @endif
                    <h1>Create Ad</h1>
                    <form action="{{ url('/dashboard/create_ad') }}" method="POST" enctype="multipart/form-data">
                      <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="spot" style="font-size: 1vw">Spot</label>
                          <select id="spot" class="form-control" name="spot" required="required" style="width: 100%" value="{{Request::old('spot')}}">
                            <option selected="selected" value="">Choose...</option>
                            @foreach($ad_spots as $ad_spot)
                            @if(old('spot') == $ad_spot->id)
                              <option selected="selected" value="{{ $ad_spot->id }}" >{{ $ad_spot->name }}</option>
                            @else
                              <option value="{{ $ad_spot->id }}">{{ $ad_spot->name }}</option>
                            @endif  
                            @endforeach
                            
                          </select>
                            @if ($errors->has('spot'))
                                <div class="error">{{ $errors->first('spot') }}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-12">
                          <label for="category" style="font-size: 1vw">Plan</label>
                          <select id="days" class="form-control" name="days" required="required" style="width: 100%" value="{{Request::old('days')}}">
                            <option selected="selected" value="">Choose...</option>
                            @foreach($ad_period as $period)
                            @if(old('days') == $period->id)
                              <option selected="selected" value="{{ $period->id }}">{{ $period->display_name }}</option>
                            @else
                              <option value="{{ $period->id }}">{{ $period->display_name }}</option>
                            @endif   
                            @endforeach
                            
                          </select>
                            @if ($errors->has('spot'))
                                <div class="error">{{ $errors->first('spot') }}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-12">
                          <label for="tittle" style="font-size: 1vw">Ad Title</label>
                          <input type="text" class="form-control {{ $errors->has('tittle') ? ' is-invalid' : '' }}" id="tittle" name="tittle" placeholder="AD Tittle" required="required"  minlength="5" maxlength="100" value="{{Request::old('tittle')}}">
                          @if ($errors->has('tittle'))
                            <div class="error">{{ $errors->first('tittle') }}</div>
                          @endif
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="website" style="font-size: 1vw">Website</label>
                        <input type="text" class="form-control{{ $errors->has('website') ? ' is-invalid' : '' }}" id="website" name="website" placeholder="https://top.test/" required="required" minlength="8" maxlength="100" value="{{Request::old('website')}}">
                        @if ($errors->has('website'))
                            <div class="error">{{ $errors->first('website') }}</div>
                        @endif
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="banner" style="font-size: 1vw">Premium Banner</label>
                            <input type="file" class="form-control-file{{ $errors->has('banner') ? ' border-fail' : '' }}" id="banner" name="banner">
                            <small id="fileHelp" class="form-text text-muted" style="font-size: 0.7vw">The file must be, JPG,JPEG,PNG or GIF. Maximun size: 5MB</small>
                            @if ($errors->has('banner'))
                                <div class="error">{{ $errors->first('banner') }}</div>
                            @endif
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="banner" style="font-size: 1vw">Link Banner</label>
                            <input type="text" class="form-control{{ $errors->has('banner_link') ? ' is-invalid' : '' }}" id="banner_link" name="banner_link" placeholder="https://yourdomain.com/image.jpg">
                            @if ($errors->has('banner_link'))
                                <div class="error">{{ $errors->first('banner_link') }}</div>
                            @endif
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="col-md-6 col-md-6 mb-2">
                            {!! NoCaptcha::display() !!}
                        </div>
                      </div>
                        @if ($errors->has('g-recaptcha-response'))
                                <div class="error mb-2"><strong style="color: red">{{ $errors->first('g-recaptcha-response') }}</strong></div>
                        @endif
                      <button type="submit" class="btn btn-primary mb-2">Submit</button>
                    </form>
        </div>
        <div class="col-md-4">
            <div class="card mt-3">
              <div class="card-header">Rules</div>
              <div class="card-body">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Not adult or ilegal content.</li>
                  <li class="list-group-item">Do not duplicate same server.</li>
                  <li class="list-group-item">No cheatin, vpn, proxy or bots.</li>
                  <li class="list-group-item">Site must be complete.</li>
                </ul>
              </div>
            </div>
            <div class="card mt-3">
              <div class="card-header">Approval</div>
              <div class="card-body">
                <p class="card-text">You can add all the sites you want but all must be approved manually. We have to verify that each site does not break any rule.</p>
              </div>
            </div>
            <div class="card mb-3 mt-3">
              <div class="card-header">Premium</div>
              <div class="card-body">
                <p class="card-text">You can purchase premium status for your site after you add it. This will give you some features.</p>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection