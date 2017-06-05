<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <i class="fa fa-bars fa-2x" aria-hidden="true"></i>
            </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">

                @foreach($menu as $menuItem)

                    @if($menuItem['title'] == 'Virtualūs kambariai')

                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Virtualus kambariai<span class="caret"></span></a>
                            <ul class="dropdown-menu">

                                @foreach($pages as $page)

                                    @foreach($page['translations'] as $translations)

                                        <li><a href="#">{{$translations['title']}}</a></li>

                                    @endforeach

                                @endforeach

                            </ul>
                        </li>

                    @else
                        <li><a href="#">{{$menuItem['title']}}</a></li>
                    @endif

                @endforeach


            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

