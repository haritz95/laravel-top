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
              <div class="card-header">Categories</div>
                <div class="tab-content" id="v-pills-tabContent">
                  <!-- TAB MY SITES -->
                  <div class="tab-pane fade show active m-3" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="row">
                      <div class="col-md-8">
                        <div class="table-responsive">
                        <table class="table table-striped">
                            <h1 class="float-left">Premium Plans</h1>
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Name</th>
                              <th scope="col">Days</th>
                              <th scope="col">Price</th>
                              <th scope="col">Discount</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($premium as $prem)
                            <tr>
                                <th>#</th>
                                <th>{{ $prem->display_name }}</th>
                                <th>{{ $prem->days }}</th>
                                <th>{{ $prem->price }} $</th>
                                <th>{{ $prem->discount_percentage }}</th>
                                <th><div class="btn-group inline pull-left">
                                    <div class="inner"><a href="#" class="btn btn-primary mr-1 edit-category" data-id="{{$prem->id}}" data-toggle="modal" data-target="#category-modal" title="Edit Cateogry" data-name="{{$prem->display_name}}"><i class="far fa-eye"></i></a></div>
                                    <div class="inner"><a href="#" class="btn btn-success mr-1 edit-category" data-id="{{$prem->id}}" data-toggle="modal" data-target="#category-modal" title="Edit Cateogry" data-name="{{$prem->display_name}}"><i class="fas fa-edit"></i></a></div>
                                    <div class="inner">
                                      <a href="javascript:;" data-toggle="modal" onclick="deleteCategory({{$prem->id}})" 
                                          data-target="#delete" class="btn btn-xs btn-danger" title="Delete Site"><i class="far fa-trash-alt"></i></a>
                                    </div>
                                </div></th>
                            </tr>
                            @endforeach
                          </tbody>
                        </table>
                    </div>
                      </div>
                      <div class="col-md-4">
                        <div><h1>Create new Plan</h1></div>
                          <form action="{{ url('/admin/premium/create') }}" method="POST" id="add-premium">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" class="form-control" id="name" name="name" placeholder="Name" required="required">
                              </div>
                              <div class="form-group">
                                <label>Days</label>
                                <input type="number" class="form-control" id="days" name="days" placeholder="30" required="required" min="0">
                              </div>
                              <div class="form-group">
                                <label>Price</label>
                                <input type="number" class="form-control" id="price" name="price" placeholder="15" required="required" min="0">
                              </div>
                              <div class="form-group">
                                <label>Discount</label>
                                <input type="number" class="form-control" id="discount" name="discount" placeholder="0" required="required" min="0">
                              </div>
                                <button class="btn btn-success add-category" type="submit">Create</button>
                        </form>
                      </div>
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
        <form class="delete" method="POST" id="deleteFormCategory">
          <input type="hidden" name="_method" value="DELETE">
            {{ csrf_field() }}
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger" onclick="formSubmitCategory()">Delete</button>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="category-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
        <h3 class="text-center">Update Category</h3>
        <div id="loading-update" class="text-center" style="display: none">
          <img src="http://top.test/images/loading.gif">
        </div>
        <form method="POST" id="category-form" enctype="multipart/form-data">
          {{ csrf_field() }}
          <div class="form-group row">
            <label for="name">Name</label>
            <input type="text" class="form-control" name="name" id="name-category" aria-describedby="emailHelp" placeholder="Name">
          </div>
          <div class="form-group row">
            <label for="name">Image</label>
            <img id="banner-image" class="img-fluid">
          </div>
          <div class="form-group row">
            <label>Banner</label>
            <input type="file" class="form-control-file{{ $errors->has('banner') ? ' border-fail' : '' }}" id="banner" name="banner">
            <small id="fileHelp" class="form-text text-muted" style="font-size: 0.7vw">The file must be, JPG,JPEG,PNG or GIF. Maximun size: 5MB</small>
          </div>
          <div class="form-group row">
            <label for="image">Image</label>
            <input type="text" class="form-control" name="banner_link" id="image-category" aria-describedby="emailHelp" placeholder="Url">
          </div>
          <button type="submit" class="btn btn-primary">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection