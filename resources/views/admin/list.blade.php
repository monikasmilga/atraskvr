@extends('admin.main')

@section('content')

    <div class="container">
        <br>
    @if(isset($error))
            <div class="alert alert-danger">
                <strong>{{ $error['message'] }}</strong>
            </div>
            <a style="margin-bottom: 50px" class="btn btn-primary btn-sm" href="{{ route('app.' . $tableName . '.create') }}">Create new {{substr($tableName, 0, -1)}}</a>
            <br>
            <a class="btn btn-warning btn-md float-right" href="http://atraskvr.dev/admin/">Admin home page</a>
        @endif
        @if(!isset($error))
            @if(isset($comment))
                <div class="alert alert-success">
                    <strong>{{ $comment['message'] }}</strong>
                </div>
            @endif
                @if(isset($message))
                    <div class="alert alert-warning">
                        <strong>{{ $message }}</strong>
                    </div>
                @endif
                    <h3>{{$tableName . ' list'}}</h3><br>
                         <a style="margin-bottom: 50px" class="btn btn-primary btn-sm" href="{{ route('app.' . $tableName . '.create') }}">Create new {{substr($tableName, 0, -1)}}</a>
                    <table class="table">
                <thead>
                <tr>
                    @foreach($fields as $key => $value)

                        @if($value == 'cover_image_id' and $tableName == 'pages')
                            <th>cover image</th>
                        @elseif($value == 'pages_categories_id' and $tableName == 'pages')
                            <th>pages category</th>
                        @elseif($value == 'parent_id' and $tableName == 'menus')
                            <th>parent</th>
                        @else
                            <th>{{$value}}</th>
                        @endif

                    @endforeach
                        @if(isset($translationExist))
                            <th>Translate</th>
                        @endif
                    <th>View</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
                </thead>
                <tbody>


                @foreach($list_data as $key => $record)
                    <tr id="{{$record['id']}}">

{{--display media--}}
                        @if(array_key_exists ('path', $record))
                            @if($record['mime_type'] == "image/jpeg" || $record['mime_type'] == "png")
                                <td>
                                    <a href="#"><img src="{{URL::asset($record['path'])}}" alt="Forest" width="80" height="150"/></a>
                                </td>
                            @endif
                            @if($record['mime_type'] == "video/mp4")
                                <td class="embed-responsive embed-responsive-4by3" style="width:80px; height:150px">
                                    <video controls preload="none">
                                        <source src="{{URL::asset($record['path'])}}"><source>
                                    </video>
                                </td>
                            @endif
                        @endif

{{--dinamic data display --}}
                        @foreach($record as $key_data => $value_data)

                            @foreach($fields as $key => $value)
                                @if($key_data == $value and $key_data == 'cover_image_id')
                                        <td><img style="width:70px" src={{asset($coverImages[$value_data])}}></td>
                                @elseif($key_data == $value and $key_data == 'pages_categories_id')
                                    <td>{{$categories[$record['pages_categories_id']]}}</td>
                                @elseif($key_data == $value and $key_data == 'parent_id')
                                    @if($record['parent_id'] != null)
                                    <td>{{$menus[$record['parent_id']]}}</td>
                                    @else
                                        <td></td>
                                    @endif
                                @elseif($key_data == $value)

                                       <td>{{$value_data}}</td>

                                @endif
                            @endforeach
                        @endforeach
                            @if(isset($translationExist))
                            <td><a class="btn btn-info btn-sm" href="{{route('app.' . $tableName . '_translations.create', $record['id'])}}"><i class="fa fa-flag fm-sm" aria-hidden="true"></i> Translate</a></td>
                            @endif
                        <td><a class="btn btn-primary btn-sm" href="{{route('app.' . $tableName . '.show', $record['id'])}}"><i class="fa fa-eye fa-sm" aria-hidden="true"></i> View</a></td>
                        <td><a class="btn btn-success btn-sm" href="{{route('app.' . $tableName . '.edit', $record['id'])}}"><i class="fa fa-pencil fa-sm" aria-hidden="true"></i> Edit</a></td>
                        <td><a href="" id="del" onclick="deleteItem('{{route('app.' . $tableName . '.delete', $record['id'])}}')" class="btn btn-danger btn-sm"><i class="fa fa-trash-o fa-sm"></i> Delete</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
                    <br>
                    <a class="btn btn-warning btn-md float-right" href="http://atraskvr.dev/admin/"><i class="fa fa-home fa-sm" aria-hidden="true"></i> Home</a>
        @endif
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
                success: function (r) {
                   $("#" + r.id).remove();

                },
                error: function () {
                    alert('error');
                }

            });

        }

    </script>
@endsection