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
              <div class="card-header">Sites</div>
                <div class="tab-content" id="v-pills-tabContent">
                  <!-- TAB MY SITES -->
                  <div class="tab-pane fade show active m-3" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <h1 class="float-left">Sites</h1><a href="{{ route('sites.create') }}" class="btn btn-danger float-right mb-2" title="Create new Site" target="blank"><i class="fas fa-plus"></i> New Site</a>
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Title</th>
                              <th scope="col">Owner</th>
                              <th scope="col"><center>Premium</center></th>
                              <th scope="col"><center>Status</center></th>
                              <th scope="col">Category</th>
                              <th scope="col">Action</th>
                              <th scope="col">Status</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($sites as $site)
                            <tr>
                                <th>#</th>
                                <th>{{ $site->title }}</th>
                                <th>{{ $site->user['name'] }}</th>
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
                                <!--<th>
                                  <div class="btn-group inline pull-left">
                                    <div class="inner">
                                      <form action="{{ route('status', $site->id) }}" method="POST">
                                        {{csrf_field()}} 
                                        {{ method_field('PATCH') }}
                                        <input type="number" name="approve" hidden="hidden" value="1">
                                        <button type="submit" class="btn btn-success mr-1" title="Approve Site"><i class="fas fa-check"></i></button>
                                      </form>
                                    </div>
                                    <div class="inner">
                                      <form action="{{ route('status', $site->id) }}" method="POST">
                                        {{csrf_field()}} 
                                        {{ method_field('PATCH') }}
                                        <button type="submit" class="btn btn-danger mr-1" title="Ban Site"><i class="fas fa-ban"></i></button>
                                      </form>
                                    </div>
                                </div>
                              </th>-->
                              <th>
                                  <div class="btn-group inline pull-left">
                                    <div class="inner">
                                      <form action="{{ route('status', $site->id) }}" method="POST" class="form-inline">
                                        {{csrf_field()}} 
                                        {{ method_field('PATCH') }}
                                        <div>
                                          <select id="status" class="js-example-basic-single js-states form-control col-md-12" name="status" required="required" style="width: 100%">
                                            @foreach($status as $statu)
                                            <option value={{$statu->id}}>{{ $statu->name }}</option>
                                            @endforeach
                                          </select> 
                                        </div>
                                        <div class="ml-2">
                                          <button type="submit" class="btn btn-success mr-1" title="Approve Site"><i class="fas fa-check"></i></button>
                                        </div>
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

<!-- Modal -->
<div class="modal fade" id="edit-site" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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