@extends('layouts.app')
@section('content')
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
              <div class="card-header">Users</div>
                <div class="tab-content" id="v-pills-tabContent">
                  <!-- TAB MY SITES -->
                  <div class="tab-pane fade show active m-3" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <h1 class="float-left">Users</h1><a class="btn btn-danger mr-1 float-right text-white" title="Ban User" data-toggle="modal" data-target="#user" title="Create new Site" onclick="$('#user-form').trigger('reset')"><i class="fas fa-plus"></i> New User</a>
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Name</th>
                              <th scope="col">Role</th>
                              <th scope="col"><center>Premium</center></th>
                              <th scope="col">Premium Untill</th>
                              <th scope="col">Status</th>
                              <th scope="col">Action</th>
                              <th scope="col">Ban User</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($users as $user)
                            <tr>
                                <th>#</th>
                                <th>{{ $user->name }}</th>
                                <th>{{ $user->role['name'] }}</th>
                                <th class="text-center">@if($user->premium == 1) <span class="badge badge-success">Yes</span>@else <span class="badge badge-danger">No</span> @endif</th>
                                <th>{{ $diff = Carbon\Carbon::parse($user->end_premium)->diffInDays(Carbon\Carbon::now()) }} days left</th>
                                <th>@if($user->status['name'] == "Active") <span class="badge badge-success">{{$user->status['name']}}</span>@elseif($user->status['name'] == "Pending") <span class="badge badge-warning">{{$user->status['name']}}</span> @else <span class="badge badge-danger">{{$user->status['name']}}</span> @endif</th>
                                <th><div class="btn-group inline pull-left">
                                    <div class="inner"><a href="#" class="btn btn-primary mr-1 user-view" data-id="{{$user->id}}" title="Edit User" data-toggle="modal" data-target="#user"><i class="fas fa-eye"></i></a></div>
                                    <div class="inner"><a href="#" class="btn btn-success mr-1 user-view" data-id="{{$user->id}}" title="Edit User" data-toggle="modal" data-target="#user"><i class="fas fa-edit"></i></a></div>
                                    <div class="inner">
                                      <a href="javascript:;" data-toggle="modal" onclick="deleteUser({{$user->id}})" 
                                          data-target="#delete" class="btn btn-xs btn-danger" title="Delete User"><i class="far fa-trash-alt"></i></a>
                                    </div>
                                </div></th>
                                <th>
                                  <div class="btn-group inline pull-left">
                                    <div class="inner">
                                      <form action="{{ route('unban', $user->id) }}" method="POST">
                                        {{csrf_field()}} 
                                        <input type="number" name="approve" hidden="hidden" value="1">
                                        <button type="submit" class="btn btn-success mr-1" title="Unban user"><i class="fas fa-check"></i></button>
                                      </form>
                                    </div>
                                    <div class="inner">
                                        <a href="javascript:;" class="btn btn-danger mr-1" title="Ban User" data-toggle="modal" data-target="#reason" onclick="banUser({{$user->id}})" ><i class="fas fa-ban"></i></a>
                                    </div>
                                </div>
                              </th>
                              <!--<th>
                                  <div class="btn-group inline pull-left">
                                    <div class="inner">
                                      <form action="{{ route('status', $user->id) }}" method="POST" class="form-inline">
                                        {{csrf_field()}} 
                                        {{ method_field('PATCH') }}
                                        <div>
                                          <select data-id="{{$user->id}}" id="status" class="js-example-basic-single js-states form-control" name="status" required="required" style="width: 100%">
                                            @foreach($status as $statu)
                                            @if($user->status_id == $statu->id)
                                            <option data-id="{{$user->id}}" selected="selected" value={{$statu->id}}>{{ $statu->name }}</option>
                                            @else
                                            <option data-id="{{$user->id}}" value={{$statu->id}}>{{ $statu->name }}</option>
                                            @endif
                                            @endforeach
                                          </select> 
                                        </div>
                                        <div class="ml-2">
                                          <button type="submit" class="btn btn-success mr-1" title="Approve Site"><i class="fas fa-check"></i></button>
                                        </div>
                                      </form>
                                    </div>
                                </div>
                              </th>-->
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
        <form class="delete" method="POST" id="deleteFormUser">
          <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="formSubmitUser()">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-confirm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <div class="icon-box">
        </div>  
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h3 class="text-center title-modal">User</h3>
        <div id="loading-update" class="text-center" style="display: none">
          <img src="http://top.test/images/loading.gif">
        </div>
        <form action="{{ route('createuser') }}" method="POST" id="user-form">
          {{ csrf_field() }}
          <div class="form-group row">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name" aria-describedby="emailHelp" placeholder="Name">
          </div>
          <div class="form-group row">
            <label for="email">Email address</label>
            <input type="email" class="form-control email-user" name="email" id="email" aria-describedby="emailHelp" placeholder="Enter email">
          </div>
          <div class="form-group row">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password">
          </div>
          <div class="form-group row">
            <label for="role">Role</label>
            <select id="role" class="form-control" name="role" required="required" style="width: 100%">
                @foreach($roles as $role)
                  <option value="{{ $role->id }}">{{ $role->name }}</option>
                @endforeach        
            </select>
          </div>
          <div class="form-group row">
            <label for="status">Status</label>
            <select id="status" class="form-control" name="status" required="required" style="width: 100%">
                @foreach($status as $statu)
                  <option value="{{ $statu->id }}">{{ $statu->name }}</option>
                @endforeach        
            </select>
          </div>
          <div class="form-group row">
            <label for="premium">Premium</label>
            <select id="premium" class="form-control" name="premium" required="required" style="width: 100%" onchange="display(this.value)">
                <option value="1">Yes</option>
                <option value="0" selected="selected">No</option>
            </select>
          </div>
          <div class="form-group row" style="display: none;" id="premium_div">
            <label for="premium_date">End Premium date</label>
            <input type="date" class="form-control" name="premium_date" id="premium_date">
          </div>
          <button type="submit" class="btn btn-primary">Create</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="reason">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Ban User</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="loading" class="text-center">
          <img src="http://top.test/images/loading.gif">
        </div>
          <div id="user_info">
            
          </div>
        <div class="form-group">
          <form method="POST" id="ban_user">
            {{ csrf_field() }}
            <div>
              <label for="comment">Expire Day:</label>
              <input type="datetime-local" name="expire_day" class="form-control">
              <small>Leave it empty if it is a permanent ban</small>
            </div>
            <div>  
              <label for="comment">Reason:</label>
              <textarea class="form-control" rows="5" id="reason" name="reason"></textarea>
            </div>  
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" onclick="formBan()">Ban</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        </form> 
      </div>
    </div>
  </div>
</div>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
@endsection