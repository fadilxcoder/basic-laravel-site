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
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ url('/add-category') }}">
                        {{ csrf_field() }}
                        <div class="form-group{{ $errors->has('category') ? ' has-error' : '' }}">
                            <label for="category" class="col-md-4 control-label">Category name</label>
                            <div class="col-md-6">
                                <input id="category" type="text" class="form-control" name="category" value="{{ old('category') }}" autofocus>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="panel-body">
                    <ul>
                        @foreach($data as $_data)
                        <li>{{ $_data->category }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
