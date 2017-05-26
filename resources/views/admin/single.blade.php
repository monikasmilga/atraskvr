@extends('admin.main')

@section('content')

    <div class="container">
        <table class="table">

            <thead>
            <tr>
                <th>key</th>
                <th>value</th>
                @foreach($languages as $key => $value)
                    <th>{{$value}}</th>
                @endforeach
            </tr>

            </thead>
            <tbody>
                @foreach($record as $key_data => $value_data)
                    @foreach($fields as $key => $value)
                        @if($key_data == $value)
                            <td>{{$key_data}}</td>
                            <td>{{$value_data}}</td>
                        @endif
                    @endforeach
                @endforeach

                @foreach($fields_translations as $key => $field_value)
                    <tr>
                    <td>{{$field_value}}</td>
                    <td></td>
                    @foreach($translations as $translation)
                        @foreach($translation as $key_translation => $value_translation)

                            {!! Form::open(['url' => route('app.' . $tableName . '.update', $record['id'])]) !!}

                                @if($field_value == $key_translation)

                                    @if($value_translation != null)

                                        @if($field_value)
                                            <td>
                                            <div class="form-group">
                                            {!! Form::text($field_value . '_' . $translation['languages_id'], $value_translation, ['class' => 'form-control'])!!}<br/>
                                            </div>
                                            </td>
                                        @endif

                                    @endif

                                @endif

                        @endforeach
                    @endforeach

                    @if(!(count($languages) == count($translations)))
                        @for($i = 1; $i <= (count($languages) - count($translations)); $i++)
                        <td>
                            <div class="form-group">
                                {{--{!! Form::text($field_value . '_' . $translation['languages_id'], $value_translation, ['class' => 'form-control'])!!}<br/>--}}
                                {!! Form::text($field_value . '_' . $languages['languages_id'], 'value_translation', ['class' => 'form-control'])!!}<br/>
                            </div>
                        </td>
                        @endfor
                    @endif
                    </tr>
                @endforeach
            </tbody>
        </table>

        {!! Form::submit('Update' , ['class' => 'btn btn-success']) !!}
        <a class="btn btn-primary" href="{{ route('app.' . $tableName . '.index') }}">{{ucfirst($tableName)}} list</a>

        {!! Form::close() !!}

        {{--<a class="btn btn-sm btn-primary" href="{{route('app.' . $tableName . '.index')}}">Back</a>--}}
        {{--<a class="btn btn-success btn-sm" href="{{route('app.' . $tableName . '.edit', $record['id'])}}">Edit</a>--}}
        {{--<a onclick="deleteItem('{{route('app.' . $tableName . '.delete', $record['id'])}}')" class="btn btn-danger btn-sm" href="{{route('app.' . $tableName . '.index')}}">Delete</a>--}}

    </div>

@endsection

@section('script')
    <script>



        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function deleteItem(route) {




            $.ajax({

                url: route,
                type: 'DELETE',
                data: {},
                dataType: 'json',
                success: function () {
                    alert('DELETED')

                },
                error: function () {
                    alert('Error');
                }

            });

        }

    </script>
@endsection