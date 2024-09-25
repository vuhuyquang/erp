<!DOCTYPE html>
<html>

<head>
    <title>@yield('title')</title>
    <style>
        @import url('https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700');

        body {
            font-family: 'Open Sans', sans-serif;
        }
    </style>
</head>

<body>

    <center>
        <h2 style="padding: 23px;background: #b3deb8a1;border-bottom: 6px green solid;">
            <p>@yield('heading')</p>
        </h2>
    </center>

    @yield('content')
</body>

</html>
