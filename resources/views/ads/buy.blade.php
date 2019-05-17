@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
      <div class="col-md-3">
            <div class="card mb-3">
              <div class="card-header">Dashboard</div>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link" href="{{  url('/dashboard/my_sites') }}" >My Sites</a>
                  <a class="nav-link" href="{{ route('sites.create') }}" aria-selected="true">New Site</a>
                  <div class="card-header">Premium</div>
                  <a class="nav-link active" href="{{  url('/dashboard/premium') }}" aria-selected="false">Buy Premium</a>
                  <div class="card-header">Ads</div>
                  <a class="nav-link" href="{{  url('/dashboard/my_ads') }}" >My Ads</a>
                  <a class="nav-link" href="{{ url('/dashboard/ad/create') }}" aria-selected="true">New Ad</a>
                  <div class="card-header">My Account</div>
                  <a class="nav-link" href="{{  url('/dashboard/my_account') }}" aria-selected="false">Account</a>
                  <a class="nav-link" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                  <form id="logout-form-dashboard" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            @if(Session::has('success'))
                <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    {{ Session::get('success') }}
                </div>
                <?php Session::forget('success');?>
              @endif
              @if(Session::has('error'))
                <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true"></button>
                    {{ Session::get('error') }}
                </div>
                <?php Session::forget('error');?>
              @endif
            <div class="card mb-3">
              <div class="card-header">Buy Ad</div>
              
                <div class="tab-content" id="v-pills-tabContent">
                  <!-- TAB MY SITES -->
                  <div class="tab-pane fade show active m-3" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                     <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{!! URL::route('paypal') !!}" >
                        {{ csrf_field() }}
                        <input value="{{ $ad->id }}" hidden="hidden" name="id">
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label>Title</label>
                            <input type="text" class="form-control" id="inputEmail4" value="{{ $ad->tittle }}" disabled="disabled">
                          </div>
                          <div class="form-group col-md-6">
                            <label>Website</label>
                            <input type="text" class="form-control" id="inputPassword4" value="{{ $ad->website }}" disabled="disabled">
                          </div>
                        </div>
                        <div class="form-row">
                          <div class="form-group col-md-12">
                            <label>Ad Spot</label>
                            <input type="text" class="form-control" id="inputEmail4" value="{{ $ad->spots['name'] }}" disabled="disabled">
                          </div>
                        </div>
                        <div class="form-row">  
                          <div class="form-group col-md-6 ">
                            <label>Website</label>
                            <img class="img-fluid" style="width: 468px; height: 60px;" src="{{ $ad->banner }}" alt="Ad Banner">
                          </div>
                          <div class="form-group col-md-6">
                          <div>
                            <h1 style="position: absolute; bottom: 0; right: 0">{{ $ad->spots['price'] }} € <small class="period">/month</small></h1>

                          </div>
                        </div>
                        </div>
                        <div class="form-group col-md-12">
                          <button type="submit" class="btn btn-block btn-primary text-uppercase" title="Buy Premium"><i class="fas fa-shopping-cart"></i> Buy</button>
                        </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
        <div class="col-md-9 col-md-offset-2">
            <div class="panel panel-default">
               
            </div>
        </div>
    </div>
</div>


@endsection
