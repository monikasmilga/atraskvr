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

			@if(isset($comment))
				<div class="alert alert-success">
  					<strong>{{ $comment['message'] }}</strong>
				</div>
			@endif
		
			{!! Form::open(['url' => route('app.' . $tableName . '.store'), 'files' => true]) !!}


			@foreach($fields as $field)


				@if($field)
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