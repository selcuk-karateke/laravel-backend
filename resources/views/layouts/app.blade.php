<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>App</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
html, body {
    background-color: #fff;
    color: #636b6f;
    font-family: 'Nunito', sans-serif;
    font-weight: 200;
    height: 100vh;
    margin: 0;
}

h1,p {

    margin: 0;
}

.title {
    font-size: 84px;
    padding: 5px;
}

.links > a {
    color: #636b6f;
    padding: 0 25px;
    font-size: 13px;
    font-weight: 600;
    letter-spacing: .1rem;
    text-decoration: none;
    text-transform: uppercase;
}
.flex-center {
    align-items: center;
    display: flex;
    justify-content: center;
}

.container {
    height:100vh;
    display: grid;
    grid-template-rows: 200px 1fr 200px;
    grid-template-columns: 30% 30% 30% 10%;
}
header {
    vertical-align: middle;
    background:lightgrey;
    grid-column-start:1;
    grid-column-end:4;
    grid-row-start:1;
    grid-row-end:2;
    padding: 10px;
}
header2 {
    vertical-align: middle;
    background:lightcoral;
    color: white;
    grid-column-start:4;
    grid-column-end:5;
    grid-row-start:1;
    grid-row-end:2;
    padding: 10px;
}
main {
    background:white;
    grid-column-start:1;
    grid-column-end:4;
    grid-row-start:2;
    grid-row-end:3;
    padding: 10px;
}
aside {
    background:lightgreen;
    grid-column-start:4;
    grid-column-end:5;
    grid-row-start:2;
    grid-row-end:3;
    padding: 10px;
}
footer {
    background:lightblue;
    grid-column-start:1;
    grid-column-end:5;
    grid-row-start:3;
    grid-row-end:4;
    padding: 10px;
}

.project {
    display: grid;
    grid-template-rows:auto;
    grid-template-columns:11% 10% 15% 8% 8% 8% 20% 20%;
    background:gold;
    padding: 10px;
}
.project div{
    word-wrap: break-word;
}
.schedule {
    display: grid;
    grid-template-rows:auto;
    grid-template-columns:10% 15% 15% 15% 15% 15% 15%;
    background:gold;
    padding: 10px;
}
</style>
    </head>
    <body>
        <div class="container">
            <header class="flex-center m-b-md">
                <p class="title">Laravel</p>
            </header>
            <header2 class="flex-center m-b-md">
                <h2>{{ $date->isoformat('dddd') }}</h2>
            </header2>
            <main>
                <div class="m-b-md">
                    @yield('projects')
                </div>
            </main>
                <aside>
                    <div class="flex-center m-b-md">
                        <h2>Nav</h2>
                    </div>
                    <div class="flex-center m-b-md">
                        @yield('content')
                    </div>
                </aside>
            <footer class="flex-center m-b-md">
                <h2>Footer</h2>
            </footer>
        </div>
    </body>
</html>
