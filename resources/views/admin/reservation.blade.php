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


            <div id="accordion" role="tablist" aria-multiselectable="true">


                @if(isset($message))

                    @if(substr($message, -1) == '!')

                        <div class="alert alert-success">
                            <strong>{{ $message }}</strong>
                        </div>

                    @else

                        <div class="alert alert-danger">
                            <strong>{{ $message }}</strong>
                        </div>

                    @endif


                @endif

                @foreach($days as $day)



                    @if($day == $date_from_url)



                        <h1 class="display-4">{{$day}}</h1>
                        @if(isset($experiences))




                            @foreach($experiences as $experience)



                                <div class="card">
                                    <div class="card-header" role="tab" id="headingOne">
                                        <h5 class="mb-0">
                                            <a data-toggle="collapse" data-parent="#accordion"
                                               href="#{{str_replace(' ', '_', $experience['translations'][0]['title'])}}"
                                               aria-expanded="true"
                                               aria-controls="{{str_replace(' ', '_', $experience['translations'][0]['title'])}}">
                                                {{$experience['translations'][0]['title']}}
                                            </a>
                                        </h5>
                                    </div>
                                    <div id="{{str_replace(' ', '_', $experience['translations'][0]['title'])}}"
                                         class="collapse" role="tabpanel" aria-labelledby="headingOne">
                                        <div class="card-block">



                                            @if($day == $today)



                                                @if(isset($disabledTimes))

                                                    @foreach($disabledTimes as $key => $value)

                                                        @if($key % 6 == 0)

                                                            <br>

                                                        @endif

                                                        <input type="checkbox" name="{{$experience['id'] . '[]'}}"
                                                               value="{{$day . ' ' . $value}}"

                                                                {{'disabled'}}

                                                        >{{$value}}


                                                    @endforeach

                                                @endif


                                                @foreach($enabledTimes as $key => $value)

                                                    @if($key % 6 == 0)

                                                        <br>

                                                    @endif

                                                    <input type="checkbox" name="{{$experience['id'] . '[]'}}"
                                                           value="{{$day . ' ' . $value}}"

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





                                            @elseif($day != $today)
                                                @foreach($times as $key => $value)

                                                    @if($key % 6 == 0)

                                                        <br>

                                                    @endif

                                                    <input type="checkbox" name="{{$experience['id'] . '[]'}}"
                                                           value="{{$day . ' ' . $value}}"

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
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    @endif
                @endforeach

            </div>


            {{csrf_field()}}
            <input class="btn btn-outline-primary submit-button" type="submit">
        </form>

    </div>


@endsection


