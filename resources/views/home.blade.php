@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            @if(count($errors) > 0)
                @foreach($errors->all() as $_err)
                <div class="alert alert-danger">{{ $_err }}</div>
                @endforeach
            @endif
            @if(session('response'))
                <div class="alert alert-success">{{ session('response') }}</div>
            @endif
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-md-4">Dashboard</div>
                        <div class="col-md-8"> 
                            <form method="POST" action="{{ url('search') }}">
                                {{ csrf_field() }}
                                <div class="input-group">
                                    <input type="text" name="search" class="form-control" placeholder="Search for...">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-default">Go!</button>
                                    </span>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="col-md-4">
                        @if(empty($profile_data))
                            <img src="{{ url('images/avatar.png') }}" alt="" class="img-responsive img-circle">
                        @else
                            <img src="{{ $profile_data->profile_picture }}" alt="" class="img-responsive img-circle">
                            <p class="lead text-center"> {{ $profile_data->designation }}</p>
                            <p class="small text-center">{{ $profile_data->name }}</p>
                        @endif
                    </div>
                    <div class="col-md-8">
                    @if( count($posts) > 0)
                        @foreach($posts as $_posts)
                        <h4>{{ $_posts->post_title }}</h4>
                        <img src="{{ url('uploads/posts/'.$_posts->post_image)}}" alt="{{ $_posts->post_image }}" class="img-responsive">
                        <p>{{ str_limit($_posts->post_body,150, '...') }}</p>
                        <ul class="nav nav-pills">
                            <li role="presentation">
                                <a href='{{ url("/view-article/{$_posts->id}") }}'><span class=" fa fa-eye"> VIEW</a>
                            </li>
                            <li role="presentation">
                                <a href="{{ url('/edit-article/'.$_posts->id) }}"><span class=" fa fa-pencil-square-o"> EDIT</a>
                            </li>
                            <li role="presentation">
                                <a href="{{ url('/delete-article/'.$_posts->id) }}"><span class=" fa fa-trash"> DELETE</a>
                            </li>
                        </ul>
                        <cite>Posted on : {{ date('M j, Y H:i', strtotime($_posts->updated_at) ) }}</cite>
                        <hr>
                        @endforeach
                        {!! $posts->links() !!}
                    @else
                        <h4 class="text-center">No Posts.</h4>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
