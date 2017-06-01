

<ul class="dropdown-menu">


    @foreach($menus as $key => $menu)

        <li role="separator" class="divider">{{$menu['title']}}</li>
    @endforeach


</ul>


<div id="menu">
<ul class="nav nav-pills">


    <li role="presentation" class="active"><a href="#">Home</a></li>
    <li role="presentation"><a href="#">Profile</a></li>
    <li role="presentation"><a href="#">Messages</a></li>
    <li role="presentation" class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            Dropdown <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="kuku">kuku</a></li>
            <li><a href="kuku">kuku</a></li>
            <li><a href="kuku">kuku</a></li>
            <li><a href="kuku">kuku</a></li>

        </ul>
    </li>
</ul>
</div>