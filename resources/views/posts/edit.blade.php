@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('/edit-article', array($specific_post->id) ) }}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('post_title') ? ' has-error' : '' }}">
                            <label for="post_title" class="col-md-4 control-label">Post title</label>
                            <div class="col-md-6">
                                <input id="post_title" type="text" class="form-control" name="post_title" value="{{ $specific_post->post_title }}" autofocus>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('post_body') ? ' has-error' : '' }}">
                            <label for="post_body" class="col-md-4 control-label">Post body</label>
                            <div class="col-md-6">
                                <textarea id="post_body" rows="5" type="text" class="form-control" name="post_body">{{ $specific_post->post_body }}</textarea>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                            <label for="category_id" class="col-md-4 control-label">Category</label>
                            <div class="col-md-6">
                                <select name="category_id" id="category_id" class="form-control">
                                <option value="{{ $selected_category->id }}" readonly>{{ $selected_category->category }}</option>
                                @if( count($categories) > 0)
                                    @foreach( $categories as $_categories)
                                    <option value="{{$_categories->id}}">{{ $_categories->category }}</option>
                                    @endforeach
                                @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group{{ $errors->has('post_image') ? ' has-error' : '' }}">
                            <label for="post_image" class="col-md-4 control-label">Featured Image</label>
                            <div class="col-md-6">
                                <input id="post_image" type="file" class="form-control" name="post_image" value="" autofocus>
                                @if ($errors->has('post_image'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('post_image') }}</strong>
                                    </span> 
                                @endif
                                <p>
                                    <img src="{{ url('/uploads/posts').'/'.$specific_post->post_image }}" alt="{{ $specific_post->post_image }}">
                                </p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary btn-large btn-block">Update post</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
