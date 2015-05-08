<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>
        @section('title')
            同行网门票预约系统
        @show
    </title>

    <!-- Bootstrap Core CSS -->
    <link href="/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
    <link href="/css/customer.css" rel="stylesheet">
    @yield('css')
</head>

<body>

    @yield('content')

    <!-- jQuery -->
    <script src="/js/jquery/jquery.min.js"></script>
    <!-- Bootstrap2.3.2 Core JavaScript -->
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    @yield('js')

</body>

</html>
