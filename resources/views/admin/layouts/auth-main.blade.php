<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />

    <link href="https://demos.creative-tim.com/material-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="https://demos.creative-tim.com/material-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />

    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">

    <link id="pagestyle"
        href="https://demos.creative-tim.com/material-dashboard-pro/assets/css/material-dashboard.min.css?v=3.0.6"
        rel="stylesheet" />
    <link rel="stylesheet" href="http://cdn.bootcss.com/toastr.js/latest/css/toastr.min.css">
    <title>@yield('title')</title>

</head>

<body class="bg-gray-200">


    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-NKDMSK6" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>

    <main class="main-content  mt-0">
        <div class="page-header align-items-start min-vh-100"
            style="background-image: url('https://images.unsplash.com/photo-1497294815431-9365093b7331?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1950&q=80');">
            <span class="mask bg-gradient-dark opacity-6"></span>
            @yield('main')
            @include('admin.layouts.auth-footer')
        </div>
    </main>

    <script src="https://demos.creative-tim.com/material-dashboard-pro/assets/js/core/popper.min.js"></script>
    <script src="https://demos.creative-tim.com/material-dashboard-pro/assets/js/core/bootstrap.min.js"></script>
    <script src="https://demos.creative-tim.com/material-dashboard-pro/assets/js/plugins/perfect-scrollbar.min.js"></script>
    <script src="https://demos.creative-tim.com/material-dashboard-pro/assets/js/plugins/smooth-scrollbar.min.js"></script>

    <script src="https://demos.creative-tim.com/material-dashboard-pro/assets/js/plugins/dragula/dragula.min.js"></script>
    <script src="https://demos.creative-tim.com/material-dashboard-pro/assets/js/plugins/jkanban/jkanban.js"></script>
    <script>
        var win = navigator.platform.indexOf('Win') > -1;
        if (win && document.querySelector('#sidenav-scrollbar')) {
            var options = {
                damping: '0.5'
            }
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
        }
    </script>

    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <script src="https://demos.creative-tim.com/material-dashboard-pro/assets/js/material-dashboard.min.js?v=3.0.6">
    </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vaafb692b2aea4879b33c060e79fe94621666317369993"
        integrity="sha512-0ahDYl866UMhKuYcW078ScMalXqtFJggm7TmlUtp0UlD4eQk0Ixfnm5ykXKvGJNFjLMoortdseTfsRT8oCfgGA=="
        data-cf-beacon='{"rayId":"7a85afa8bc610438","version":"2023.2.0","r":1,"token":"1b7cbb72744b40c580f8633c6b62637e","si":100}'
        crossorigin="anonymous"></script>
    <script src="http://cdn.bootcss.com/jquery/3.6.0/jquery.min.js"></script>
    <script src="http://cdn.bootcss.com/toastr.js/latest/js/toastr.min.js"></script>
    {!! Toastr::message() !!}
</body>

</html>
