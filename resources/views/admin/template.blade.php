<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ url('assets/css/admin/style.css') }}" />
</head>
<body>
    <header>
        <ul>
            <a href="{{route('dashboard')}}" {{$active=='home'?'class=active':''}} ><li>Dashboard</li></a>
            <a href="{{route('post.index')}}" {{$active=='post'?'class=active':''}}><li>Postagens</li></a>
            <a href="" {{$active=='slider'?'class="active"':''}}><li>Sliders</li></a>
            <a href="" {{$active=='highlights'?'class="active"':''}}><li>Destaques</li></a>
            @if ($user->master===1)
                <a href=""><li>Usúarios</li></a>
            @endif
        </ul>

        <div class="header--right">
            <span>{{ $user->name }}</span>
            <a href="{{route('logout')}}">Sair</a>
        </div>
    </header>
    
    @yield('content')

    <script src="https://kit.fontawesome.com/07df3e3170.js" crossorigin="anonymous"></script>
</body>
</html>
