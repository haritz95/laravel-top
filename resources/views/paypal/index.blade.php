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
              <div class="card-header">Buy Premium</div>
              
                <div class="tab-content" id="v-pills-tabContent">
                  <!-- TAB MY SITES -->
                  <div class="tab-pane fade show active m-3" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <h3 class="text-center">Your account @if(Auth::user()->premium) is Premium and expires in <b>{{ $diff = Carbon\Carbon::parse(Auth::user()->end_premium)->diffInDays(Carbon\Carbon::now()) }}</b> days @else is not Premium @endif</h3>
                    <h5 class="text-center">We will add 1 more month to your current expire date</h5>
                    <section class="pricing py-5">
                      <div class="container">
                        <div class="row">
                          <!-- Plus Tier -->
                          <div class="col-lg-12">
                            <div class="card mb-5 mb-lg-0">
                              <div class="card-body text-white">
                                <form class="form-horizontal" method="POST" id="payment-form" role="form" action="{!! URL::route('paypal') !!}" >
                                {{ csrf_field() }}
                                <h5 class="card-title text-uppercase text-center">Premium</h5>
                                <h6 class="card-price text-center">$15<span class="period">/month</span></h6>
                                <hr>
                                <ul class="fa-ul">
                                  <li><span class="fa-li"><i class="fas fa-check"></i></span>Unlimited Sites</li>
                                  <li><span class="fa-li"><i class="fas fa-check"></i></span>Premium Banner</li>
                                  <li><span class="fa-li"><i class="fas fa-check"></i></span>Premium Descripction</li>
                                  <li><span class="fa-li"><i class="fas fa-check"></i></span>Special Color</li>
                                  <li><span class="fa-li"><i class="fas fa-check"></i></span>Montlhy boost Votes</li>
                                </ul>
                                 <button type="submit" class="btn btn-block btn-primary text-uppercase" title="Buy Premium"><i class="fas fa-shopping-cart"></i> Buy</button>
                                <form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
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
