@php
    $dt = Carbon\Carbon::now();
    $day = $dt->isoformat('dddd');
    $week = $dt->weekOfYear;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>App</title>
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            html, body {
    background-color: #fff;
    font-family: 'Nunito', sans-serif;
    font-weight: 200;
    height: 100vh;
    margin: 0;
}
h1,p {

    margin: 0;
    color: black;
}

input, textarea {
    border-radius: 0 !important;
    border-color: lightblue !important;
}
table {
    table-layout: fixed;
    word-wrap: break-word;
}
.table-hover tbody tr:hover td, .table-hover tbody tr:hover th {
    background-color:lavender;
}
.btn {
    border-radius: 0;
}

.title {
    color: white;
    font-size: 84px;
    padding: 5px;
}
.sub-title {
    color: black;
    font-size: 72px;
    padding: 5px;
}
.links > a {
    color: black;
    padding: 0 25px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
}
.flex-center-1 {
    align-items: center;
    display: flex;
    justify-content: center;
}
.flex-center-2 {
    align-items: center;
    justify-content: center;
}
.header-1 {
    vertical-align: middle;
    background:lightgrey;
    padding: 10px;
}
.header-2 {
    vertical-align: middle;
    background:lightcoral;
    color: white;
    padding: 10px;
}
.main-1 {
    background:white;
    margin-bottom: 4rem;
    padding: 10px;
}
.aside-1 {

    background:lightgreen;
    padding: 10px;
}
.footer-1 {
    position: fixed;
    left: 0;
    bottom: 0;
    width: 100%;
    background:lightblue;
    padding: 10px;
    text-align: center;
}
.project div{
    word-wrap: break-word;
}
.task {
    display: grid;
    grid-template-rows:auto;
    grid-template-columns:10% 15% 15% 15% 15% 15% 15%;
    background:lightgoldenrodyellow;
    padding: 10px;
}
</style>
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">
                <div class="header-1 flex-center-1 col-12 col-md-10">
                    @yield('title')
                </div>
                <div class="header-2 flex-center-1 col-6 col-md-2">
                    <h2>{{ $day }}</h2><br>
                    Woche {{ $week }}
                </div>
            </div>

            <div class="row" style="height: 80vh;">
                <div class="main-1 flex-center-1 col-6 col-md-10">
                    @yield('content')
                </div>
                <div class="aside-1 aside-down flex-center-2 col-6 col-md-2">
                    <h2 class="flex-center-1">Menu</h2>
                    <div class="links">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/home') }}">{{ Auth::user()->name }}</a> |

                                <a href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt"></i>
                                </a><br/>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form><br/><br/>

                                <a href='{{ url('/projects') }}'>Projects</a><br/>
                                <a href='{{ url('/tasks') }}'>Tasks</a><br/><br/>
                            @else
                                <a href="{{ route('login') }}">Login</a><br/>

                                @if (Route::has('register'))
                                    <a href="{{ route('register') }}">Register</a><br/>
                                @endif
                            @endauth

                            <br/>
                            <a href='{{ url('/') }}'>Main</a></p><br/>
                        @endif
                        @yield('aside')
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="footer-1 col-12">
                    <h2>Laravel BTA</h2>
                </div>
            </div>
        </div>
    </body>
</html>
