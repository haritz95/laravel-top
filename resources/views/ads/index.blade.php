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
                  <a class="nav-link active" href="{{  url('/dashboard/my_ads') }}" >My Ads</a>
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
            @if(session()->has('message'))
                <div class="alert alert-success">
                    <center><h3>{{ session()->get('message') }}</h3></center>
                </div>
            @endif
            <div class="card mb-3">
              <div class="card-header">My Ads</div>
                <div class="tab-content" id="v-pills-tabContent">
                  <!-- TAB MY ADS -->
                  <div class="tab-pane active m-3" id="t-my-ads" role="tabpanel" aria-labelledby="my-ads-tab">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <h1 class="float-left">My Ads</h1><a href="{{ url('/dashboard/ad/create') }}" class="btn btn-danger float-right mb-2" title="Create new Site"><i class="fas fa-plus"></i> New Ad</a>
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Title</th>
                              <th scope="col">Expires</th>
                              <th scope="col">Spot</th>
                              <th scope="col">Status</th>
                              <th scope="col">Views</th>
                              <th scope="col">Clics</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($my_ads as $ad)
                            <tr>
                                <th>#</th>
                                <th>{{ $ad->tittle }}</th>
                                @if($ad->active === 1)
                                <th>{{ $diff = Carbon\Carbon::parse($ad->end_ad)->diffInDays(Carbon\Carbon::now()) }} days</th>
                                @else
                                <th class="text-center">-</th>
                                @endif
                                <th>{{ $ad->spots['name'] }}</th>
                                <th>@if($ad->active == 1) <span class="badge badge-success">ACTIVE</span> @else <span class="badge badge-danger">INACTIVE</span> @endif</th>
                                <th>{{ $ad->views }}</th>
                                <th>{{ $ad->clicks }}</th>
                                <th><div class="btn-group inline pull-left">
                                    <div class="inner"><a href="{{ URL::to('/preview_ad/'.$ad->id)}}" class="btn btn-primary mr-1" title="Preview Ad"><i class="far fa-eye"></i></a></div>
                                    <div class="inner"><a href="{{ URL::to('ad/'.$ad->id)}}" class="btn btn-success mr-1" title="Edit Ad"><i class="fas fa-edit"></i></a></div>
                                    <div class="inner">
                                      <a href="javascript:;" data-toggle="modal" onclick="deleteAd({{$ad->id}})"
                                          data-target="#delete" class="btn btn-xs btn-danger mr-1" title="Delete Ad"><i class="far fa-trash-alt"></i></a>
                                    </div>
                                    <div class="inner"><a href="{{ URL::to('/buy/'.$ad->id)}}" class="btn btn-dark mr-1" title="Preview Ad"><i class="fas fa-shopping-cart"></i></a></div>
                                </div></th>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>
                  </div>
                  </div>
                  </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-confirm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="icon-box">
          <i class="fas fa-exclamation-circle"></i>
        </div>  
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 class="text-center">Are you sure you want to delete this?</h3>
        <form class="delete" method="POST" id="deleteFormAd">
          <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="formSubmit()">Delete</button>
      </div>
    </div>
  </div>
</div>

@endsection