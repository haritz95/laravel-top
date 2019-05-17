@extends('layouts.app')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-3">
              <div class="card-header">Dashboard</div>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link" href="{{  url('/dashboard/my_sites') }}" >My Sites</a>
                  <a class="nav-link" href="{{ route('sites.create') }}" aria-selected="true">New Site</a>
                  <div class="card-header">Premium</div>
                  <a class="nav-link" href="{{  url('/dashboard/premium') }}" aria-selected="false">Buy Premium</a>
                  <div class="card-header">Ads</div>
                  <a class="nav-link" href="{{  url('/dashboard/my_ads') }}" >My Ads</a>
                  <a class="nav-link" href="{{ url('/dashboard/ad/create') }}" aria-selected="true">New Ad</a>
                  <div class="card-header">My Account</div>
                  <a class="nav-link active" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Account</a>
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
            <div class="card mb-3">
              <div class="card-header">My Account</div>
                <div class="tab-content" id="v-pills-tabContent">
                  <!-- TAB ACCOUNT -->
                  <div class="tab-pane m-3 active" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                    <div class="alert alert-danger" id="pass_info" role="alert" style="display: none;">
                      
                    </div>
                    <div class="float-right">
                      @if(Auth::user()->premium) <img src="{{ URL::to('/') }}/images/Premium.png" height="100px"> @endif
                      <small>Expires in {{ $diff = Carbon\Carbon::parse(Auth::user()->end_premium)->diffInDays(Carbon\Carbon::now()) }} days</small>
                    </div>
                    <div>
                    <h1>My Account</h1>
                    </div>
                    <div class="form-group">
                      <label>Username</label>
                      <input type="text" name="username" class="form-control" value="{{ Auth::user()->name }}" disabled="disabled">
                      <small>The username can not be changed.</small>
                    </div>
                    <form>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                    <div class="form-group"> 
                      <label>E-mail</label>
                      <input type="text" name="username" class="form-control" value="{{ Auth::user()->email }}" disabled="disabled">
                      <small>The E-mail can not be changed.</small>
                    </div>
                    <div class="form-group"> 
                      <label>Current Password</label>
                      <input type="password" name="current-password" id="current-password" class="form-control" required="required" minlength="8">
                    </div>
                    <div class="form-group"> 
                      <label>New Password</label>
                      <input type="password" name="password" id="password" class="form-control" required="required" minlength="8">
                    </div>
                    <div class="form-group"> 
                      <label>Confirm Password</label>
                      <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required="required" minlength="8">
                    </div>
                    <button class="btn btn-success"  id="update_account" title="Update Account">Update</button>
                    </form>
                    </div>
                  </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection