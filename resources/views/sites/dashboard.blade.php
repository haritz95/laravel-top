@extends('layouts.app')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class="card mb-3">
              <div class="card-header">Dashboard</div>
                <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                  <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">My Sites</a>
                  <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Buy Premium</a>
                  <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Create Ad</a>
                  <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">Account</a>
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
              <div class="card-header">My Sites</div>
                <div class="tab-content" id="v-pills-tabContent">
                  <div class="tab-pane fade show active m-3" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <h1 class="float-left">My Sites</h1><a href="{{ route('sites.create') }}" class="btn btn-danger float-right mb-2"><i class="fas fa-plus"></i> New Site</a>
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Title</th>
                              <th scope="col">Description</th>
                              <th scope="col">Category</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($sites as $site)
                            <tr>
                                <th>#</th>
                                <th>{{ $site->title }}</th>
                                <th>{{ $site->description }}</th>
                                <th>{{ $site->category['name'] }}</th>
                                <th><div class="btn-group inline pull-left">
                                    <div class="inner"><a href="{{ route('sites.show', $site->id) }}" class="btn btn-primary mr-1"><i class="far fa-eye"></i></a></div>
                                    <div class="inner"><a href="{{ route('sites.edit', $site->id) }}" class="btn btn-success mr-1"><i class="fas fa-edit"></i></a></div>
                                    <div class="inner">
                                      <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$site->id}})" 
                                          data-target="#delete" class="btn btn-xs btn-danger"><i class="far fa-trash-alt"></i></a>
                                    </div>
                                </div></th>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">...</div>
                  <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">...</div>
                  <div class="tab-pane m-3" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                    <div class="alert alert-danger" role="alert" style="display: none;">
                      
                    </div>
                    <h1>My Account</h1>
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
                      <input type="password" name="current-password" id="current-password" class="form-control {{($errors->first('current-password') ? " form-error" : "")}}  @if(session()->has('not_match'))form-error @endif">
                      @if ($errors->has('current-password'))
                        <div class="error">{{ $errors->first('current-password') }}</div>
                      @endif
                      @if(session()->has('not_match'))
                        <div class="error">{{ session()->get('not_match') }}</div>
                      @endif
                    </div>
                    <div class="form-group"> 
                      <label>New Password</label>
                      <input type="password" name="password" id="password" class="form-control {{($errors->first('password') ? " form-error" : "")}}">
                      @if ($errors->has('password'))
                        <div class="error">{{ $errors->first('password') }}</div>
                    @endif
                    </div>
                    <div class="form-group"> 
                      <label>Confirm Password</label>
                      <input type="password" name="password_confirmation" id="password_confirmation" class="form-control {{($errors->first('password_confirmation') ? " form-error" : "")}}">
                      @if ($errors->has('password_confirmation'))
                        <div class="error">{{ $errors->first('password_confirmation') }}</div>
                    @endif
                    </div>
                    <button class="btn btn-success"  id="update_account">Update</button>
                    </form>
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
        <button type="button" class="btn btn-danger" onclick="formSubmit()">Delete</button>
      </div>
    </div>
  </div>
</div>

@endsection