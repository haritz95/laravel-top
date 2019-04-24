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
                  <div class="tab-pane fade m-3" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <h1>Create Ad</h1>
                    <form>
                      <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="spot" style="font-size: 1vw">Spot</label>
                          <select id="spot" class="form-control" name="spot" required="required" style="width: 100%" value="{{Request::old('spot')}}">
                            <option selected="selected" value="">Choose...</option>
                            @foreach($ad_spots as $ad_spot)
                              <option value="{{ $ad_spot->id }}">{{ $ad_spot->name }}</option>
                            @endforeach
                            
                          </select>
                            @if ($errors->has('spot'))
                                <div class="error">{{ $errors->first('spot') }}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-12">
                          <label for="category" style="font-size: 1vw">Spot</label>
                          <select id="days" class="form-control" name="days" required="required" style="width: 100%" value="{{Request::old('spot')}}">
                            <option selected="selected" value="">Choose...</option>
                            @foreach($ad_period as $period)
                              <option value="{{ $period->days }}">{{ $period->display_name }}</option>
                            @endforeach
                            
                          </select>
                            @if ($errors->has('spot'))
                                <div class="error">{{ $errors->first('spot') }}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-12">
                          <label for="title" style="font-size: 1vw">Ad Title</label>
                          <input type="text" class="form-control" id="title" name="ad_title" placeholder="AD Tittle" required="required"  minlength="5" maxlength="100" value="{{Request::old('ad_tittle')}}">
                          @if ($errors->has('ad_tittle'))
                            <div class="error">{{ $errors->first('ad_tittle') }}</div>
                          @endif
                        </div>
                      </div>
                      <div class="form-group">
                        <label for="website" style="font-size: 1vw">Website</label>
                        <input type="text" class="form-control{{($errors->first('website') ? " form-error" : "")}}" id="website" name="website" placeholder="https://top.test/" required="required" minlength="8" maxlength="100" value="{{Request::old('website')}}">
                        @if ($errors->has('website'))
                            <div class="error">{{ $errors->first('website') }}</div>
                        @endif
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="banner" style="font-size: 1vw">Upload Banner</label>
                            <input type="file" class="form-control-file" id="banner_upload" name="banner">
                            <small id="fileHelp" class="form-text text-muted" style="font-size: 0.7vw">The file must be, JPG,JPEG,PNG or GIF. Maximun size: 5MB</small>
                            @if ($errors->has('banner'))
                                <div class="error">{{ $errors->first('banner') }}</div>
                            @endif
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-12">
                          <label for="banner" style="font-size: 1vw">Link Banner</label>
                            <input type="text" class="form-control" id="banner_link" name="banner" placeholder="https://yourdomain.com/image.jpg">
                            @if ($errors->has('banner'))
                                <div class="error">{{ $errors->first('banner') }}</div>
                            @endif
                        </div>
                      </div>
                      <button class="btn btn-primary mb-2" id="create_ad">Submit</button>
                    </form>
                  </div>
                  <div class="tab-pane m-3" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                    <div class="alert alert-danger" id="pass_info" role="alert" style="display: none;">
                      
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