<!DOCTYPE html>
<html lang="en">

<head>
    {{-- <title>Administrator Portal | StayMgt HR</title> --}}
    {{-- <title>SSC | StayMgt HR</title> --}}
    <title>Login | StayMgt HR</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="{{ asset('vendor/login_v18/images/icons/favicon.ico') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/login_v18/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendor/adminlte-3.1.0/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendor/login_v18/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/login_v18/vendor/animate/animate.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendor/login_v18/vendor/css-hamburgers/hamburgers.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendor/login_v18/vendor/animsition/css/animsition.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/login_v18/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('vendor/login_v18/vendor/daterangepicker/daterangepicker.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/login_v18/css/util.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/login_v18/css/main.css') }}">
</head>

<body style="background-color: #666666;">

    <div class="limiter">
        <div class="container-login100">
            <div class="wrap-login100">
                <form action="{{ route('auth.login') }}" method="post" id="login_form"
                    class="login100-form validate-form">
                    {{ csrf_field() }}
                    <span class="login100-form-title p-b-43">
                        Login
                        {{-- Self-Service Center (SSC) / Administrator Portal --}}
                    </span>
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @include('layouts.adminlte_3.components.alert')

                    <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                        <input type="email" id="email" name="email" class="input100" placeholder=""
                            {{ old('email') }} value="">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Email</span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Password is required">
                        <input type="password" id="password" name="password" class="input100" placeholder=""
                            value="">
                        <span class="focus-input100"></span>
                        <span class="label-input100">Password</span>
                    </div>

                    <div class="flex-sb-m w-full p-t-3 p-b-32">
                        <div>
                            <a href="{{ route('register.index') }}" class="txt1">
                                Sign up
                            </a>
                            <br>
                            <a href="{{ route('password.request') }}" class="txt1">
                                Forget password?
                            </a>
                        </div>
                        <div class="contact100-form-checkbox">
                            <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember"
                                {{ old('remember') ? 'checked' : '' }}>
                            <label class="label-checkbox100" for="ckb1">
                                Remember me
                            </label>
                        </div>

                    </div>

                    <!-- TODO change button color -->
                    <div class="container-login100-form-btn">
                        <button class="login100-form-btn">
                            Login
                        </button>
                    </div>
                </form>

                {{-- <div class="login100-more" style="background-image: url('{{ asset('vendor/login_v18/images/bg-01.jpg') }}');"> --}}
                <div class="login100-more"
                    style="background-image: url('{{ asset('vendor/login_v18/images/bg-02.jpg') }}');">
                    <div
                        style="background: rgba(51, 138, 94, 0.7); z-index: 2; overflow: hidden; height: 100%; width: 100%;">
                        <div
                            style="font-size: 65px; color: white; margin-top: 200px; margin-left: 50px; text-transform: uppercase;">
                            Financial Simulator
                        </div>
                        {{-- <div style="font-size: 65px; color: white; margin-top: -25px; margin-left: 50px; text-transform: uppercase;">
                            Human Resources
                        </div>
                        <div style="font-size: 14px; color: whitesmoke; margin-top: 0px; margin-left: 50px;">
                            AI powered Office Automation System
                        </div> --}}
                    </div>
                </div>
                <!-- inset 0 0 0 100vmax -->

            </div>
        </div>
    </div>

    <script>
        function onSubmit(token) {
            document.getElementById("login_form").submit();
        }
    </script>

    <script src="{{ asset('vendor/login_v18/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('vendor/login_v18/vendor/animsition/js/animsition.min.js') }}"></script>
    <script src="{{ asset('vendor/login_v18/vendor/bootstrap/js/popper.js') }}"></script>
    <script src="{{ asset('vendor/login_v18/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('vendor/login_v18/vendor/select2/select2.min.js') }}"></script>
    <script src="{{ asset('vendor/login_v18/vendor/daterangepicker/moment.min.js') }}"></script>
    <script src="{{ asset('vendor/login_v18/vendor/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('vendor/login_v18/vendor/countdowntime/countdowntime.js') }}"></script>
    <script src="{{ asset('vendor/login_v18/js/main.js') }}"></script>
</body>

</html>
