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
                            <h1 class="float-left">Categories</h1>
                          <thead>
                            <tr>
                              <th scope="col">#</th>
                              <th scope="col">Name</th>
                              <th scope="col">Image</th>
                              <th scope="col">Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($categories as $category)
                            <tr>
                                <th>#</th>
                                <th>{{ $category->name }}</th>
                                <th><img src="{{$category->image}}" style="height: 60px; width: 100px"></th>
                                <th><div class="btn-group inline pull-left">
                                    <div class="inner"><a href="#" class="btn btn-primary mr-1 edit-category" data-id="{{$category->id}}" data-toggle="modal" data-target="#category-modal" title="Edit Cateogry" data-name="{{$category->name}}" data-image="{{$category->image}}"><i class="far fa-eye"></i></a></div>
                                    <div class="inner"><a href="#" class="btn btn-success mr-1 edit-category" data-id="{{$category->id}}" data-toggle="modal" data-target="#category-modal" title="Edit Cateogry" data-name="{{$category->name}}" data-image="{{$category->image}}"><i class="fas fa-edit"></i></a></div>
                                    <div class="inner">
                                      <a href="javascript:;" data-toggle="modal" onclick="deleteCategory({{$category->id}})" 
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
                        <div><h1>Create Category</h1></div>
                          <form action="{{ url('/admin/category/create') }}" method="POST" enctype="multipart/form-data" id="add-category">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                            <div class="form-group">
                              <label>Banner</label>
                            <input type="file" class="form-control-file{{ $errors->has('banner') ? ' border-fail' : '' }}" id="banner" name="banner">
                              <small id="fileHelp" class="form-text text-muted" style="font-size: 0.7vw">The file must be, JPG,JPEG,PNG or GIF. Maximun size: 5MB</small>
                              </div>
                              <div class="form-group">
                                <label>URL</label>
                                <input type="text" class="form-control{{ $errors->has('banner_link') ? ' is-invalid' : '' }}" id="banner_link" name="banner_link" placeholder="https://yourdomain.com/image.jpg">
                              </div>
                            <label>Category</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" placeholder="Category" name="category" id="category-name" required="required">
                              <div class="input-group-append">
                                <button class="btn btn-success add-category" type="button">Add</button>
                              </div>
                            </div>
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