@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-3">
              <div class="card-header">Dashboard</div>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link active" href="{{  url('/dashboard/my_sites') }}" >My Sites</a>
                  <a class="nav-link" href="{{ route('sites.create') }}" aria-selected="true">New Site</a>
                  <div class="card-header">Premium</div>
                  <a class="nav-link" href="{{  url('/dashboard/premium') }}" aria-selected="false">Buy Premium</a>
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
            @if(session()->has('message'))
                <div class="alert alert-success">
                    <center><h3>{{ session()->get('message') }}</h3></center>
                </div>
            @endif
            <div class="card mb-3">
              <div class="card-header">My Sites</div>
                <div class="tab-content" id="v-pills-tabContent">
                  <!-- TAB MY SITES -->
                  <div class="tab-pane fade show active m-3" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <h1 class="float-left">My Sites</h1><a href="{{ route('sites.create') }}" class="btn btn-danger float-right mb-2" title="Create new Site"><i class="fas fa-plus"></i> New Site</a>
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Title</th>
                              <th scope="col"><center>Premium</center></th>
                              <th scope="col"><center>Status</center></th>
                              <th scope="col">Category</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($sites as $site)
                            <tr>
                                <th>#</th>
                                <th>{{ $site->title }}</th>
                                <th><center>@if($site->user['premium'] == 1) <span class="badge badge-success">Yes</span>@else <span class="badge badge-danger">No</span></center> @endif</th>
                                <th><center>@if($site->status['name'] == "Active") <span class="badge badge-success">{{$site->status['name']}}</span>@elseif($site->status['name'] == "Pending") <span class="badge badge-warning">{{$site->status['name']}}</span> @else <span class="badge badge-danger">{{$site->status['name']}}</span></center> @endif</th>
                                <th>{{ $site->category['name'] }}</th>
                                <th><div class="btn-group inline pull-left">
                                    <div class="inner"><a href="{{ route('sites.show', $site->id) }}" class="btn btn-primary mr-1" title="View Site"><i class="far fa-eye"></i></a></div>
                                    <div class="inner"><a href="{{ route('sites.edit', $site->id) }}" class="btn btn-success mr-1" title="Edit Site"><i class="fas fa-edit"></i></a></div>
                                    <div class="inner">
                                      <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$site->id}})" 
                                          data-target="#delete" class="btn btn-xs btn-danger" title="Delete Site"><i class="far fa-trash-alt"></i></a>
                                    </div>
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
        <form class="delete" method="POST" id="deleteForm">
          <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="formSubmitSite()">Delete</button>
      </div>
    </div>
  </div>
</div>

@endsection