@extends('admin.main')

@section('content')

	<div class="container">
		<div class="col-md-12">

			<h3>Create new: {{substr($tableName, 0, -1)}}</h3>

			@if(isset($error))
				<div class="alert alert-danger">
  					<strong>{{ $error['message'] }}</strong>
				</div>
			@endif

			@if(isset($message))
				@if(sizeof($message > 0))
					<div class="alert alert-warning">
						<strong>{{ $message }}</strong>
					</div>
				@endif
			@endif


			{!! Form::open(['url' => route('app.' . $tableName . '.store'), 'files' => true]) !!}

			@foreach($fields as $field)
				@if($field == 'user_id')

                @elseif(isset($enum_dropDown))
                    <div class="form-group">
                        {!! Form::label($enum_dropDown['label'], 'Choose ' . $enum_dropDown['label']) !!}
                        {{Form::select($enum_dropDown['label'], $enum_dropDown['values'], '', ['class' => 'form-control'])}}<br/>
                    </div>

                @elseif(isset($dropdown) and $field == 'parent_id')
                    <div class="form-group">
                        {!! Form::label($field, 'Choose ' . ucfirst(substr($field, 0, -3) . ':')) !!}
                        {{Form::select($field, $dropdown[$field], '', ['class' => 'form-control'])}}<br/>
                    </div>

{{--Categories dropdown. --}}
{{--## substr($field, -4) == 's_id' ## translates to ## $field == 'pages_categories_id' ##--}}

                @elseif(isset($dropdown) and substr($field, -4) == 's_id')
                    <div class="form-group">
                        {!! Form::label($field, 'Choose ' . ucfirst(substr($field, 0, -3) . ':')) !!}
                        {{Form::select($field, [null=>'Please Select'] + $dropdown[$field], '', ['class' => 'form-control'])}}<br/>
                    </div>

{{--Cover img dropdown. Display dropdown fields for the cover img selection from VRResources--}}
                {{--## substr($field, -4) == 's_id' ## translates to ## $field == 'cover_image_id' ##--}}

                @elseif($field == 'cover_image_id' and $tableName == 'pages')
                    @if($dropdown[$field] != null)
                        <div class="form-group">
                            {!! Form::label($field, 'Choose ' . ucfirst(substr($field, 0, -3) . ' from database:')) !!}
                            {{Form::select($field,[null=>'Please Select'] + $dropdown[$field],'', ['class' => 'form-control'])}}<br/>
                        </div>
                    @endif

{{--Cover img button. Display the file select button--}}

                    @if($tableName == 'pages')
                        <div class="form-group">
                            {!! Form::label($field, 'Upload ' . ucfirst(substr($field, 0, -3) . ':')) !!}<br/>
                            {!! Form::file('image')!!}<br/>
                        </div><br/>
                    @endif

                    {{--@elseif(isset($dropdown) and substr($field, -3) == '_id')--}}
                    {{--<div class="form-group">--}}
                      {{--{!! Form::label($field, 'Choose ' . ucfirst(substr($field, 0, -4) . ':')) !!}--}}
                      {{--{{Form::select($field, $dropdown[$field], '', ['class' => 'form-control'])}}<br/>--}}
                    {{--</div>--}}

{{--Multi button 1. Display media upload button for multiple files IN PAGES CREATE. Used in 'create new page' and also 'create --}}
                    <div class="form-group">
                        {!! Form::label('images', 'Upload Media files:' ) !!}<br>
                        {!! Form::file('images[]', array('multiple'=>true)) !!}<br/>
                    </div>
{{--Multi button 2.Display media upload button for multiple files in 'create new resource'--}}
                @elseif((substr($field, -4) == 'e_id') || ($field == 'path' and $tableName == 'resources'))
                    <div class="form-group">
                        {!! Form::file('images[]', array('multiple'=>true)) !!}<br/>
                    </div>

                @elseif(isset($checkbox[$field]))
                        {!! Form::label($field, 'Pick ' . ucfirst($field . ':')) !!}<br/>
                @foreach($checkbox[$field] as $key => $checkboxItem)
                        {{Form::checkbox($field.'[]', $key)}}
                        {{Form::label($checkboxItem, $checkboxItem)}}<br/>
                @endforeach<br/>

                @elseif($field == 'password')
                    <div class="form-group">
                        {!! Form::label($field, 'Enter ' . ucfirst($field . ':')) !!}
                        {!! Form::password($field, ['class' => 'form-control'])!!}<br/>
                    </div>

                @elseif($field && $tableName != 'resources')
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