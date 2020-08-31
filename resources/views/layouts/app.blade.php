@php
    $dt = Carbon\Carbon::now();
    $day = $dt->isoformat('dddd');
    $week = $dt->weekOfYear
@endphp
    <!DOCTYPE html>
<html lang="de">
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
    <link href="{{ asset('css/customs.css') }}" rel="stylesheet">
</head>
<body>
<a name="top"></a>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-xl-10 head-1">
            <span class="title">Laravel - Backend</span>
        </div>
        <div class="col-12 col-xl-2 head-2 flex-1">
            <div class="links text-white">
                @if (Route::has('login'))
                    @auth
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="text-white">
                        <i class="fas fa-sign-out-alt fa-fw"></i> | Logout
                    </a>
                    @endauth
                @endif
            </div>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form><br/>
        </div>
    </div>
</div>
<style>
    #wrapper {
        /*border: 1px solid blue;*/
        /*display: table;*/
        width:100%;
    }
    .divs {
        display: table-cell;
    }
    #leftdiv {
        /*border: 3px solid red;*/
        height: 100%;
    }
    #rightdiv {
        /*border: 3px solid green;*/
        /*height: 100%;*/
    }
</style>
<div class="container-fluid" id="wrapper">
    <div class="row">
        <div class="col-md-10 main" id="leftdiv">
            <section class="col-12">
                @yield('section-1')
            </section>
            <section class="col-12 flex-3 ">
                @yield('section-2')
            </section>
            <section class="col-12 flex-1">
                @yield('section-3')
            </section>
        </div>
        <style>
            a > i {
                font-size: large;
            }
        </style>
        <div class="col-md-2 aside" id="rightdiv" >
            <div class="links">
                @if (Route::has('login'))
                    @auth
                        <p>{{ Auth::user()->name }}</p><br/>
                        <a href="{{ url('/dashboard') }}"><i class="fas fa-user-circle fa-fw"></i> | Dashboard</a><br/>
                        <a href='{{ url('/projects') }}'><i class="fas fa-list fa-fw"></i> | Projects</a><br/>
                        <a href='{{ url('/tasks') }}'><i class="fas fa-tasks fa-fw"></i> | Tasks</a><br/><br/>
                    @else
                        <a href="{{ route('login') }}">Login</a><br/>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a><br/>
                        @endif
                    @endauth

                    <br/>
                    <a href='{{ url('/') }}'><i class="fas fa-home"></i> | Main</a><br/>
                @endif
                @yield('aside')
            </div>
        </div>
    </div>
</div>
<div class="container-fluid fixed-bottom">
    <div class="row">
        <div class="col-12 col-xl-10 foot-1 divs">
            {{ $day }} / Week {{ $week }}
        </div>
        <div class="col-12 col-xl-2 foot-2 text-right divs">
            <a href="#top" class="text-white"><i class="fas fa-arrow-up fa-fw"></i></a>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
            integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
            crossorigin="anonymous">
    </script>
</body>
</html>
    {{--@TODO AJAX ohne Form Collective bauen: https://appdividend.com/2018/02/07/laravel-ajax-tutorial-example/--}}
<script>
    jQuery(document).ready(function(){
        jQuery('#ajaxSubmit').click(function(e){
            e.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }
            });
            jQuery.ajax({
                    url: "{{ route('tasks.store') }}",
                method: 'post',
                data: {
                    name: jQuery('#name').val(),
                    description: jQuery('#description').val(),
                    employee_id: jQuery('#employee_id').val(),
                    status: jQuery('#status').val(),
                    estimated_hours: jQuery('#estimated_hours').val(),
                    real_hours: jQuery('#real_hours').val(),
                    calendar_week: jQuery('#calendar_week').val(),
                    task_end: jQuery('#task_end').val(),
                    real_end: jQuery('#real_end').val(),
                    charged: jQuery('#charged').val(),
                },
                success: function(result){
                    jQuery('.alert').show();
                    jQuery('.alert').html(result.success);
                }});
        });
    });
</script>
