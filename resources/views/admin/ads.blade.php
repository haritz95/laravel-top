@extends('layouts.app')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
<div class="container-fluid">
    <div class="row">
        @include('layouts.admin_sidebar')
        <div class="col-md-10">
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
                            <h1 class="float-left">My Ads</h1><a href="{{ url('/dashboard/ad/create') }}" class="btn btn-danger float-right mb-2" title="Create new Site" target="blank"><i class="fas fa-plus"></i> New Ad</a>
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Title</th>
                              <th scope="col">User</th>
                              <th scope="col">Expires</th>
                              <th scope="col">Spot</th>
                              <th scope="col">Status</th>
                              <th scope="col">Views</th>
                              <th scope="col">Clics</th>
                              <th scope="col">Action</th>
                              <th scope="col">Active</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($my_ads as $ad)
                            <tr>
                                <th>#</th>
                                <th>{{ $ad->tittle }}</th>
                                 <th>{{ $ad->user['name'] }}</th>
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
                                </div></th>
                                <th>
                                  <div class="btn-group inline pull-left">
                                    <div class="inner">
                                      <form action="{{ route('activatead', $ad->id) }}" method="POST">
                                        {{csrf_field()}} 
                                        <input type="number" name="approve" hidden="hidden" value="1">
                                        <button type="submit" class="btn btn-success mr-1" title="Active ad"><i class="fas fa-check"></i></button>
                                      </form>
                                    </div>
                                    <div class="inner">
                                        <form action="{{ route('activatead', $ad->id) }}" method="POST">
                                        {{csrf_field()}} 
                                        <input type="number" name="approve" hidden="hidden" value="0">
                                        <button type="submit" class="btn btn-danger mr-1" title="Desactive ad"><i class="fas fa-ban"></i></button>
                                      </form>
                                    </div>
                                </div>
                              </th>
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