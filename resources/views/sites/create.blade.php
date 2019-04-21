@extends('layouts.app')
@section('content')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.3/Chart.bundle.js"></script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
        @if(session()->has('message'))
                <div class="alert alert-danger">
                    <center><h3>{{ session()->get('message') }}</h3></center>
                </div>
            @endif
      </div>
        <div class="col-md-8">
            <form action="{{ url('/site/store') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="category" style="font-size: 1vw">Category</label>
                  <select id="category" class="js-example-basic-single js-states form-control" name="category" required="required" style="width: 100%" value="{{Request::old('category')}}">
                    @foreach($categories as $category)
                    <option selected="selected" value="">Choose...</option>
                    <option value={{$category->id}}>{{ $category->name }}</option>
                    @endforeach
                  </select>
                    @if ($errors->has('category'))
                        <div class="error">{{ $errors->first('category') }}</div>
                    @endif
                </div>
                <div class="form-group col-md-12">
                  <label for="title" style="font-size: 1vw">Title</label>
                  <input type="text" class="form-control" id="title" name="title" placeholder="Title" required="required" value="{{Request::old('title')}}">
                  @if ($errors->has('title'))
                    <div class="error">{{ $errors->first('title') }}</div>
                  @endif
                </div>
              </div>
              <div class="form-group">
                <label for="description" style="font-size: 1vw">Description</label>
                <textarea class="form-control" rows="3" id="description" name="description" placeholder="Description" required="required">{{Request::old('description')}}</textarea>
                @if ($errors->has('description'))
                    <div class="error">{{ $errors->first('description') }}</div>
                @endif
              </div>
              <div class="form-group">
                <label for="website" style="font-size: 1vw">Website</label>
                <input type="text" class="form-control" id="website" name="website" placeholder="https://top.test/" required="required" value="{{Request::old('website')}}">
                @if ($errors->has('website'))
                    <div class="error">{{ $errors->first('website') }}</div>
                @endif
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="category" style="font-size: 1vw">Tags</label>
                  <select id="tags" class="form-control" name="tags[]" multiple="multiple" style="width: 100%">
                  @if (is_array(old('tags')))
                    @foreach (old('tags') as $tag)
                        <option value="{{ $tag }}" selected="selected">{{ $tag }}</option>
                    @endforeach
                  @endif            
                  </select>
                    @if ($errors->has('tags'))
                        <div class="error">{{ $errors->first('tags') }}</div>
                    @endif
                  <small id="tagsHelp" class="form-text text-muted" style="font-size: 0.7vw">Example: 3.3.5, Custom, Fun, Blizzlike...</small>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group col-md-12">
                  <label for="banner" style="font-size: 1vw">Premium Banner</label>
                    <input type="file" class="form-control-file" id="banner" name="banner">
                    <small id="fileHelp" class="form-text text-muted" style="font-size: 0.7vw">The file must be, JPG,JPEG,PNG or GIF. Maximun size: 5MB</small>
                    @if ($errors->has('banner'))
                        <div class="error">{{ $errors->first('banner') }}</div>
                    @endif
                </div>
              </div>
              <button type="submit" class="btn btn-primary mb-2">Submit</button>
            </form>
        </div>
        <div class="col-md-4">
            <div class="card mt-3">
              <div class="card-header">Rules</div>
              <div class="card-body">
                <ul class="list-group list-group-flush">
                  <li class="list-group-item">Not adult or ilegal content.</li>
                  <li class="list-group-item">Do not duplicate same server.</li>
                  <li class="list-group-item">No cheatin, vpn, proxy or bots.</li>
                  <li class="list-group-item">Site must be complete.</li>
                </ul>
              </div>
            </div>
            <div class="card mt-3">
              <div class="card-header">Approval</div>
              <div class="card-body">
                <p class="card-text">You can add all the sites you want but all must be approved manually. We have to verify that each site does not break any rule.</p>
              </div>
            </div>
            <div class="card mb-3 mt-3">
              <div class="card-header">Premium</div>
              <div class="card-body">
                <p class="card-text">You can purchase premium status for your site after you add it. This will give you some features.</p>
              </div>
            </div>
        </div>
    </div>
</div>

@endsection