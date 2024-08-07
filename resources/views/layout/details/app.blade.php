<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Front-End | {{ $title }}</title>

    <!-- Favicons -->
    <link href="{{asset('assets/img/favicon.png')}}" rel="icon">
    <link href="{{asset('assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
          integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css"
          integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    <style>
        .toggle-password-eye {
            float: right;
            top: -25px;
            right: 10px;
            position: relative;
            cursor: pointer;
        }
    </style>

    <style>
        body {
            font-family: "Roboto", sans-serif;
            background-color: #fff;
        }

        p {
            color: #b3b3b3;
            font-weight: 300;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            font-family: "Roboto", sans-serif;
        }

        a {
            -webkit-transition: .3s all ease;
            -o-transition: .3s all ease;
            transition: .3s all ease;
        }

        a:hover {
            text-decoration: none !important;
        }

        .content {
            padding: 7rem 0;
        }

        h2 {
            font-size: 20px;
        }

        .half,
        .half .container > .row {
            height: 100vh;
            min-height: 700px;
        }

        @media (max-width: 991.98px) {
            .half .bg {
                height: 200px;
            }
        }

        .half .contents {
            background: #f6f7fc;
        }

        .half .contents,
        .half .bg {
            width: 50%;
        }

        @media (max-width: 1199.98px) {

            .half .contents,
            .half .bg {
                width: 100%;
            }
        }

        .half .contents .form-control,
        .half .bg .form-control {
            border: none;
            -webkit-box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);
            border-radius: 4px;
            height: 54px;
            background: #fff;
        }

        .half .contents .form-control:active,
        .half .contents .form-control:focus,
        .half .bg .form-control:active,
        .half .bg .form-control:focus {
            outline: none;
            -webkit-box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.1);
        }

        .half .bg {
            background-size: cover;
            background-position: center;
        }

        .half a {
            color: #888;
            text-decoration: underline;
        }

        .half .btn {
            height: 54px;
            padding-left: 30px;
            padding-right: 30px;
        }

        .half .forgot-pass {
            position: relative;
            top: 2px;
            font-size: 14px;
        }

        .control {
            display: block;
            position: relative;
            padding-left: 30px;
            margin-bottom: 15px;
            cursor: pointer;
            font-size: 14px;
        }

        .control .caption {
            position: relative;
            top: .2rem;
            color: #888;
        }

        .control input {
            position: absolute;
            z-index: -1;
            opacity: 0;
        }

        .control__indicator {
            position: absolute;
            top: 2px;
            left: 0;
            height: 20px;
            width: 20px;
            background: #e6e6e6;
            border-radius: 4px;
        }

        .control--radio .control__indicator {
            border-radius: 50%;
        }

        .control:hover input ~ .control__indicator,
        .control input:focus ~ .control__indicator {
            background: #ccc;
        }

        .control input:checked ~ .control__indicator {
            background: #fb771a;
        }

        .control:hover input:not([disabled]):checked ~ .control__indicator,
        .control input:checked:focus ~ .control__indicator {
            background: #fb8633;
        }

        .control input:disabled ~ .control__indicator {
            background: #e6e6e6;
            opacity: 0.9;
            pointer-events: none;
        }

        .control__indicator:after {
            font-family: 'icomoon';
            content: '\e5ca';
            position: absolute;
            display: none;
            font-size: 16px;
            -webkit-transition: .3s all ease;
            -o-transition: .3s all ease;
            transition: .3s all ease;
        }

        .control input:checked ~ .control__indicator:after {
            display: block;
            color: #fff;
        }

        .control--checkbox .control__indicator:after {
            top: 50%;
            left: 50%;
            margin-top: -1px;
            -webkit-transform: translate(-50%, -50%);
            -ms-transform: translate(-50%, -50%);
            transform: translate(-50%, -50%);
        }

        .control--checkbox input:disabled ~ .control__indicator:after {
            border-color: #7b7b7b;
        }

        .control--checkbox input:disabled:checked ~ .control__indicator {
            background-color: #7e0cf5;
            opacity: .2;
        }
    </style>

</head>

<body>
<div class="d-lg-flex half">
    <div class="bg order-1 order-md-2" style="background-image: url('assets/img/sports-field.jpg'); height: 900px;" >
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-12 col-sm-12">
                    <div class="login-brand">
                        <div class="simple-footer">
                            <!--                            <h1 class="text-success">CONTENT MANAGEMENT SYSTEM (CMS)</h1>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="contents order-2 order-md-1">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7">
                    <img src="{{asset('assets/img/fitlife.png')}}" alt="website logo" class="logo-dark mxw-300"
                         width="382" height="157">
                    @yield('content')
                    <div class="simple-footer">
                        <p>NC Corp Software Development &copy; {{ date('Y') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- General JS Scripts -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
        integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.6/jquery.nicescroll.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="{{ asset('assets/js/stisla.js') }}"></script>

<!-- Template JS File -->
<script src="{{ asset('assets/js/scripts.js') }}"></script>
<script src="{{ asset('assets/js/custom.js') }}"></script>

<script>
    const togglePasswordEye = '<i class="fa fa-eye toggle-password-eye"></i>';
    const togglePasswordEyeSlash = '<i class="fa fa-eye-slash toggle-password-eye"></i>';

    $(togglePasswordEyeSlash).insertAfter('input[type=password]');
    $('input[type=password]').addClass('hidden-pass-input')

    $('body').on('click', '.toggle-password-eye', function (e) {
        let password = $(this).prev('.hidden-pass-input');

        if (password.attr('type') === 'password') {
            password.attr('type', 'text');
            $(this).addClass('fa-eye').removeClass('fa-eye-slash');
        } else {
            password.attr('type', 'password');
            $(this).addClass('fa-eye-slash').removeClass('fa-eye');
        }
    })
</script>

</body>

</html>
