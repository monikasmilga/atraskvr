@extends('admin.main')

@section('content')

    <div class="container">
        <div class="col-md-12"><br>

            <h3>Create & update {{$tableName . ' translations'}}</h3><br>
            <table class="table">

                <thead class="thead-default">
                <tr>
                    <th>key</th>
                    <th>value</th>
                    @foreach($languages_names as $key => $value)
                        <th>{{$value}}</th>
                    @endforeach
                </tr>

                </thead>
                <tbody>
                @foreach($record as $key_data => $value_data)
                    @foreach($fields as $key => $value)
                        @if($key_data == $value)
                            <tr>
                                <td>{{$key_data}}</td>
                                <td>{{$value_data}}</td>
                            </tr>
                        @endif
                    @endforeach
                @endforeach

                @foreach($fields_translations as $key => $field_value)
                    <tr>
                        <td>{{$field_value}}</td>
                        <td></td>

                        {!! Form::open(['url' => route('app.' . $tableName . '.update', $record['id'])]) !!}

                        @foreach($languages as $key => $language)

                            @if(count($translations) == 0)
                                    <td>
                                        <div class="form-group">
                                            {!! Form::text($field_value . '_' . $language, 'translation value', ['class' => 'form-control'])!!}<br/>
                                        </div>
                                    </td>
                            @endif

                            @foreach($translations as $translation)

                                @if($translation['languages_id'] == $language)

                                    @foreach($translation as $key_translation => $value_translation)

                                        @if($field_value == $key_translation)

                                            @if($field_value)
                                                <td>
                                                    <div class="form-group">
                                                        {!! Form::text($field_value . '_' . $translation['languages_id'], $value_translation, ['class' => 'form-control'])!!}<br/>
                                                    </div>
                                                </td>
                                            @endif

                                        @endif

                                    @endforeach

                                    @break

                                @else

                                    @if(end($translations) == $translation)

                                    @if($field_value)
                                        <td>
                                            <div class="form-group">
                                                {!! Form::text($field_value . '_' . $language, 'translation value', ['class' => 'form-control'])!!}<br/>
                                            </div>
                                        </td>
                                    @endif

                                    @endif

                                @endif

                            @endforeach

                        @endforeach

                    </tr>
                @endforeach
                </tbody>
            </table>

        {!! Form::submit('Create / Update' , ['class' => 'btn btn-success']) !!}
        <a class="btn btn-primary" href="{{ route('app.' . $tableName . '.index') }}">{{ucfirst($tableName)}} list</a>

        {!! Form::close() !!}
        </div>
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