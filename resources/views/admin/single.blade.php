@extends('admin.main')

@section('content')

    <div class="container"><br>
        <h3>
        @if(isset($record['name']))
            @if($record['name']!= null)
                @if(isset($record['name']))
                    {{ucfirst($record['name'])}}
                @endif
            @endif
        @else
                @if($tableName == 'pages_categories')
                    {{ucfirst(substr($tableName, 0, -3)) . 'y'}}
                @else{{ucfirst(substr($tableName, 0, -1))}}
                @endif
        @endif

        </h3><br>
        <table class="table">
            <thead class="thead-default">
            <tr>
                <th>key</th>
                <th>value</th>
            </tr>

            </thead>
            <tbody>

                @foreach($record as $key => $value)
                    <tr id="{{$record['id']}}">
                        @if($key == 'cover_image_id' and $tableName == 'pages')
                            <td>cover image</td>
                            <td><img src={{asset($coverImage)}}/></td>
                        @elseif($key == 'pages_categories_id')
                            <td>pages category</td>
                            <td>{{$category}}</td>
                        @elseif($key == 'count')
                        @else
                            <td>{{$key}}</td>
                            <td>{{$value}}</td>
                        @endif
                    </tr>
                @endforeach

            </tbody>
        </table>

        <h3>
            @if($translations != null)
                @if(isset($record['name']))
                    {{ucfirst($record['name'] . ' translations')}}
                @else
                    @if($tableName == 'pages_categories')
                    {{ucfirst(substr($tableName, 0, -3)) . 'y translations'}}
                    @else{{ucfirst(substr($tableName, 0, -1)) . ' translations'}}
                    @endif
                @endif
            @endif
        </h3><br>
        <table class="table">
            <tbody>
            @foreach($translations as $translation)
                <thead class="thead-default">
                <tr>
                    <th></th>
                    <th>{{$languages_names[$translation['languages_id']]}}</th>
                </tr>
                </thead>
                @foreach($translation as $key_translation => $value_translation)

                    <tr>
                        @foreach($fields_translations as $key_field => $value_field)
                            @if($value_field == $key_translation)
                                <td>{{$key_translation}}</td>
                                <td>{{$value_translation}}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            @endforeach
            </tbody>
        </table>

        <a class="btn btn-sm btn-primary" href="{{route('app.' . $tableName . '.index')}}">Back</a>
        <a class="btn btn-success btn-sm" href="{{route('app.' . $tableName . '.edit', $record['id'])}}">Edit</a>
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