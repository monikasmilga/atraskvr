@extends ('admin.main')

@section('content')

    <div class="container">
        <div class="col-md-12">

            <h3>Create new: {{substr($tableName, 0, -1)}}</h3>

            @if(isset($error))
                <div class="alert alert-danger">
                    <strong>{{ $error['message'] }}</strong>
                </div>
            @endif

            @if(isset($comment))
                <div class="alert alert-success">
                    <strong>{{ $comment['message'] }}</strong>
                </div>
            @endif

            {!! Form::open(['url' => route('app.' . $tableName . '.store')]) !!}


            @foreach($fields as $field)

                @if(isset($dropdown) and substr($field, -3) == '_id')

                    <div class="form-group">
                        {!! Form::label($field, 'Choose ' . ucfirst(substr($field, 0, -4) . ':')) !!}
                        {{Form::select($field ,$dropdown[$field], '', ['class' => 'form-control'])}}<br/>
                    </div>

                @elseif(isset($checkbox[$field]))
                    {!! Form::label($field, 'Pick ' . ucfirst($field . ':')) !!}<br/>
                    @foreach($checkbox[$field] as $key => $checkboxItem)
                        {{Form::checkbox($field.'[]', $key)}}
                        <span @if($key == $cache) style="font-weight:700" @endif>
							{{Form::label($checkboxItem, $checkboxItem)}}</span><br/>
                    @endforeach<br/>

                @elseif($field == 'password')
                    <div class="form-group">
                        {!! Form::label($field, 'Enter ' . ucfirst($field . ':')) !!}
                        {!! Form::password($field, ['class' => 'form-control'])!!}<br/>
                    </div>

                @elseif($field == 'description_long' || $field == 'description_short')
                    <div class="form-group">
                        {!! Form::label($field, 'Enter ' . ucfirst($field . ':')) !!}
                        {!! Form::textarea($field, '', ['class' => 'form-control'])!!}<br/>
                    </div>

                @elseif($field)
                    <div class="form-group">
                        {!! Form::label($field, 'Enter ' . ucfirst($field . ':')) !!}
                        {!! Form::text($field, '', ['class' => 'form-control'])!!}<br/>
                    </div>
                @endif

            @endforeach


            {!! Form::submit('Create' , ['class' => 'btn btn-success']) !!}
            <a class="btn btn-primary" href="{{ route('app.' . $tableName . '.index') }}">{{ucfirst($tableName)}} list</a>

            {!! Form::close() !!}
        </div>
    </div>

@endsection