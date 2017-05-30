@extends('admin.main')

@section('content')

    <div class="container">
        <div class="col-md-12"><br>
            <h3>
            @if(isset($record['name']))
                @if($record['name']!= null)
                    @if(isset($record['name']))
                        {{ucfirst($record['name']) . ' translations'}}
                    @endif
                @endif
            @else
                @if($tableName == 'pages_categories')
                    {{ucfirst(substr($tableName, 0, -3)) . 'y translations'}}
                @else{{ucfirst(substr($tableName, 0, -1)) . ' translations'}}
                @endif
            @endif
            </h3><br>

            <table class="table">
                <thead class="thead-default">
                <tr>
                    <th>Key</th>
                    @foreach($languages_names as $key => $value)
                        <th>{{$value}} value</th>
                    @endforeach
                </tr>
                </thead>
                <tbody>
                @foreach($fields_translations as $key => $field_value)
                    <tr>
                        <td>{{$field_value}}</td>

                        {!! Form::open(['url' => route('app.' . $tableName . '_translations.create', $record['id'])]) !!}

                        @foreach($languages as $key => $language)

                            @if(count($translations) == 0)
                                    <td>
                                        <div class="form-group">
                                            {!! Form::textarea($field_value . '_' . $language, 'translation value', ['class' => 'form-control', 'rows'=>"3"])!!}<br/>
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
                                                        {!! Form::textarea($field_value . '_' . $translation['languages_id'], $value_translation, ['class' => 'form-control', 'rows'=>"3"])!!}<br/>
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
                                                {!! Form::textarea($field_value . '_' . $language, 'translation value', ['class' => 'form-control', 'rows'=>"3"])!!}<br/>
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
