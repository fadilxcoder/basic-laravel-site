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
                <div class="panel-heading">Post View</div>
                <div class="panel-body">
                    <div class="col-md-4">
                        <ul class="list-group">
                        @if(count($categories) > 0)
                            @foreach( $categories->all() as $cat)
                            <li class="list-group-item"><a href="{{ url('category/'.$cat->id) }}">{{ $cat->category}}</a></li>
                            @endforeach
                        @else
                            <li>No category found </li>
                        @endif
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <h4>{{ $specific_post[0]->post_title }}</h4>
                        <img src="{{ url('uploads/posts/'.$specific_post[0]->post_image) }}" alt="{{ $specific_post[0]->post_image }}" class="img-responsive">
                        <br>
                        <p>{{ $specific_post[0]->post_body }}</p>
                        <ul class="nav nav-pills">
                            <li role="presentation">
                                <a href='{{ url("/like/{$specific_post[0]->id}") }}'><span class=" fa fa-thumbs-up"> {{ count($likes)}}</a>
                            </li>
                            <li role="presentation">
                                <a href="{{ url('/dislike/'.$specific_post[0]->id) }}"><span class=" fa fa-thumbs-down"> {{ count($dislikes)}}</a>
                            </li>
                            <li role="presentation">
                                <a href="#"><span class=" fa fa-comment-o"></a>
                            </li>
                        </ul>
                        <form method="POST" action="{{ url('comment/'.$specific_post[0]->id) }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                                <textarea id="comment" rows="6" class="form-control" name="comment"  autofocus></textarea>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-lg btn-block">Post Comment</button>
                            </div>
                        </form>
                        <h3>Comments</h3>
                        @if(count($comments) > 0)
                            @foreach($comments as $c)
                                <p>{{ $c->comment }}</p>
                                <h6><i>Posted by : {{ $c->name }}</i></h6>
                                <br/>
                            @endforeach
                        @else
                            <p>No Comments!</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
