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
                    {{--Single Record and single page cover image display--}}
                    @if(($key == 'cover_image_id' && $tableName == 'pages') || ($key == "mime_type" && $tableName == 'resources'))
                        @if($mediaInfo['mime_type'] == "image/jpeg" ||$mediaInfo['mime_type'] == "png")
                            <td>{{$key}}</td>
                            <td>{{$value}}</td>
                            <tr>
                                <td>Image</td>
                                <td><img src="{{asset($image)}}"></td>
                            </tr>
                        @elseif($mediaInfo['mime_type'] == "video/mp4")
                            <td>Video</td>
                            <td class="embed-responsive embed-responsive-4by3">
                                <video controls preload="none">
                                    <source src="{{asset($record['path'])}}">
                                </video>
                            </td>
                        @endif


                    {{--@if($key == 'cover_image_id' and $tableName == 'pages')--}}
                    {{--<td>cover image</td>--}}
                    {{--<td><img src={{asset($image)}}/></td>--}}

                    @elseif($key == 'pages_categories_id')
                        <td>pages category</td>
                        <td>{{$category}}</td>
                    @elseif($key == 'parent_id')
                        <td>parent id</td>
                        @if($value != null )
                          <td>{{$parent_id[$record['parent_id']]}}</td>
                        @endif
                    @elseif($key == 'count')
                    @else
                        <td>{{$key}}</td>
                        <td>{{$value}}</td>
                    @endif

                    </tr>
            @endforeach

            </tbody>

        </table>

        {{--Connected media table. Display the media connected to page via pages_resources_connections--}}

        @if(isset($connectedMediaDataArrays['connectedMediaData']))
            <a href=></a><h3>Connected media data</h3><br>
            @foreach ($connectedMediaDataArrays['connectedMediaData'] as $mediaDataArray)
                <table class="table" style="table-layout: fixed; word-wrap:break-word">
                    <thead class="thead-default">
                    <tr>
                        @if($loop->iteration == 1)
                            <th>madia type</th>
                            <th>media file</th>
                            @foreach($mediaDataArray as $key => $value)
                                <th>{{$key}}</th>
                            @endforeach
                        @endif
                    </tr>
                    </thead>
                    <tbody>
                    <tr>

                        @if($mediaDataArray['mime_type'] == "image/jpeg" || $mediaDataArray['mime_type'] == "png")
                            <td>Image</td>
                            <td><img src="{{asset($mediaDataArray['path'])}}" width="90" , height="120"></td>
                        @elseif($mediaDataArray['mime_type'] == "video/mp4")
                            <td>Video</td>
                            <td class="embed-responsive embed-responsive-4by3">
                                <video controls preload="none">
                                    <source src="{{asset($mediaDataArray['path'])}}">
                                </video>
                            </td>
                        @endif

                        @foreach($mediaDataArray as $key => $value)
                            <td>{{$value}}</td>
                        @endforeach
                    </tr>
                    </tbody>
                </table>
            @endforeach
        @endif

        @if(isset($translationExist))
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
        @endif

        <a class="btn btn-sm btn-primary" href="{{route('app.' . $tableName . '.index')}}">Back</a>
        <a class="btn btn-success btn-sm" href="{{route('app.' . $tableName . '.edit', $record['id'])}}">Edit</a>
    </div><br><br>

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