@extends('admin.main')


@section('content')


    <div class="container">
    <nav aria-label="...">
        <ul class="pagination pagination-lg justify-content-center">




    @foreach($days as $day)

                <li class="page-item

                @if($date_from_url == $day)
                      {{' active'}}
                @endif

                "><a class="page-link" href="{{route('app.reservations.create', $day)}}">{{$day}}</a></li>

    @endforeach

        </ul>

    </nav>

    <br><br>




    <form method="POST" action="{{route('app.reservations.store')}}">

        @foreach($days as $day)
            <div class="date-checkbox-group">

                @if($day == $date_from_url)

                    <h1 class="display-4">{{$day}}</h1>

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

    </div>


@endsection