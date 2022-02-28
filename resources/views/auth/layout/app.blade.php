<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Talk Tales</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="Talk Tales Apps" name="description" />
    <meta content="" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png') }}">

    <!-- App css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />

</head>

<body class="account-body accountbg">

    <div class="container">
        <div class="row vh-100 d-flex justify-content-center">
            <div class="col-12 align-self-center">
                <div class="row">
                    <div class="col-lg-5 mx-auto">
                        <div class="card">
                            <div class="card-body p-0 auth-header-box">
                                <div class="text-center p-3">
                                    <a href="{{route('index')}}" class="logo logo-admin">
                                        <img src="{{ asset('assets/images/logo.png') }}" height="50" alt="logo" class="auth-logo">
                                    </a>
                                    <h4 class="mt-3 mb-1 font-weight-semibold text-white font-18">Let's Get Started Talk Tales</h4>
                                    <p class="text-muted  mb-0">Sign in to continue to Talk Tales.</p>
                                </div>
                            </div>
                            <div class="card-body p-0">

                                @yield('tab')

                            </div>
                            <!--end card-body-->
                        </div>
                        <!--end card-->
                    </div>
                    <!--end col-->
                </div>
                <!--end row-->
            </div>
            <!--end col-->
        </div>
        <!--end row-->
    </div>
    <!--end container-->
    <!-- End Log In page -->


    <!-- jQuery  -->
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap.bundle.min.') }}js"></script>
    <script src="{{ asset('assets/js/waves.js') }}"></script>
    <script src="{{ asset('assets/js/feather.min.') }}js"></script>
    <script src="{{ asset('assets/js/simplebar.min.js') }}"></script>


</body>

</html>