@extends('admin.main')
@section('content')

    <div class="container">
        <div class="col-md-12">
            <div class="form-group">

                {!! Form::open(['url' => route('app.resources.store'), 'files' => true]) !!}
                {!! Form::file('thefile')!!}
                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection