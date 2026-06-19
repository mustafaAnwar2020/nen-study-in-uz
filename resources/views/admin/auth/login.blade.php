<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin login</title>
    <link href="{{asset($settings['media']->fav_icon)}}" rel="icon">
    <link href="{{asset($settings['media']->fav_icon)}}" rel="apple-touch-icon">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/assets/dist/css/adminlte.min_en.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fonts/fonts.css')}}">
    <style>
        body {
            background: linear-gradient(to right, rgba(0, 128, 255, 0.2), rgb(142 142 142))
        }
    </style>

</head>
<body class="hold-transition login-page">
<div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-dark">
        <div class="card-header text-center">
            <img src="{{asset('assets/logo.png')}}" width="100" alt="logo">
        </div>
        <div class="card-body">
            <p class="login-box-msg">
                Login to Admin Dashboard
            </p>

            <form action="{{ url('/admin/login') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="username" class="form-control" placeholder="User Name">
                </div>
                <div class="input-group mb-3">
                    <input name="password" type="password" class="form-control" placeholder="Password">
                </div>
                <div class="row">
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark btn-block">Login</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<script src="/assets/plugins/jquery/jquery.min.js"></script>
<script src="/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="/assets/dist/js/adminlte.min.js"></script>
@include('includes.toastr')
</body>
</html>

