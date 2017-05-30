@extends('admin.main')


@section('content')





        <form method="POST" action="{{route('app.reservations.store')}}">

            @foreach($days as $day)

                {{--@if($today == $day)--}}

            {{$day}}

                    @foreach($experiences as $experience)

                        {{$experience['translations'][0]['title']}}

                        @foreach($times as $key => $value)

                            @if($key % 6 == 0)

                                <br>

                            @endif

                            <input type="checkbox" name="{{$experience['id'] . '[]'}}" value="{{$day . ' ' . $value}}">{{$value}}

                        @endforeach


                        <br>
                    @endforeach

                {{--@endif--}}



                    <br>
            @endforeach
                {{csrf_field()}}
                <input class="btn btn-sm btn-primary" type="submit">
        </form>


@endsection