@extends('admin.main')

@section('content')

    <div class="container">
        <table class="table">

            <thead>
            <tr>
                <th>key</th>
                <th>value</th>
            </tr>

            </thead>
            <tbody>

                @foreach($record as $key => $value)
                    <tr>
                        <td>{{$key}}</td>
                        @if($key == 'resources_id' and $tableName == 'ingredients')
                            <td><img src={{asset($ingredientImage)}}/></td>
                        @else
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