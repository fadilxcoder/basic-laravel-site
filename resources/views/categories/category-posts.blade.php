@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
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
                                <a href="#"><span class=" fa fa-trash"> DELETE</a>
                            </li>
                        </ul>
                        <cite>Posted on : {{ date('M j, Y H:i', strtotime($_posts->updated_at) ) }}</cite>
                        <hr>
                        @endforeach
                        {{-- $posts->links() --}}
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
