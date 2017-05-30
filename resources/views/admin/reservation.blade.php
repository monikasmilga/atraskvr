@extends('admin.main')


@section('content')


    @foreach($days as $day)

        <a href="{{$day}}">{{$day}}</a><br>

    @endforeach

    <br><br>




    <form method="POST" action="{{route('app.reservations.store')}}">

        @foreach($days as $day)
            <div class="date-checkbox-group">

                @if($day == $date_from_url)

                    <p>{{$day}}</p>

                    @foreach($experiences as $experience)
                        <div class="experience-checkbox-group">
                            {{$experience['translations'][0]['title']}}

                            @foreach($times as $key => $value)

                                @if($key % 6 == 0)

                                    <br>

                                @endif
                                    <input type="checkbox" name="{{$experience['id'] . '[]'}}" value="{{$day . ' ' . $value}}"

                                        @if(isset($reservations))
                                            @foreach($reservations as $reservation)

                                                @foreach($reservation['time'] as $time)

                                                    @if($time == $day . ' ' . $value && $experience['id'] == $reservation['pages_id'])

                                                        {{'disabled'}}

                                                    @endif

                                                @endforeach

                                            @endforeach

                                        @endif

                                    >{{$value}}





                            @endforeach


                            <br>
                        </div>
                    @endforeach


                @elseif($date_from_url == null)

                    <h1>Nera datos</h1>


                @endif




            </div>

        @endforeach
            {{csrf_field()}}
            <input class="btn btn-sm btn-primary" type="submit">
    </form>


@endsection