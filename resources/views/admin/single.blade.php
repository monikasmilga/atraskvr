@extends('admin.main')

@section('content')

    <div class="container"><br>
        @if(isset($record['name']))
        <h3>{{ucfirst($record['name'])}}</h3><br>
        @endif
        <table class="table">
            <thead>
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
                        {{--@elseif($key == 'pages_categories_id')--}}
                            {{--<td>pages category</td>--}}
                            {{--<td>{{$record['category']['name']}}/></td>--}}
                        @else
                            <td>{{$key}}</td>
                            <td>{{$value}}</td>
                        @endif
                    </tr>
                @endforeach

            </tbody>
        </table>

        <a class="btn btn-sm btn-primary" href="{{route('app.' . $tableName . '.index')}}">Back</a>
        <a class="btn btn-success btn-sm" href="{{route('app.' . $tableName . '.edit', $record['id'])}}">Edit</a>
        <a onclick="deleteItem('{{route('app.' . $tableName . '.delete', $record['id'])}}')" class="btn btn-danger btn-sm" href="{{route('app.' . $tableName . '.index')}}">Delete</a>

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