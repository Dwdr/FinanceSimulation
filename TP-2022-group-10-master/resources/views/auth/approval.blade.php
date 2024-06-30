{{-- Parent Layout --}}
@extends('templates.dark_admin_1_4_4.login')

{{-- Title --}}
@section('html_title', 'Login | FA Database')

{{-- Body Main Content --}}
@section('body_main_content')
    <div class="login-page">
        <div class="container d-flex align-items-center">
            <div class="form-holder has-shadow">
                <div class="row">
                    <!-- Logo & Information Panel-->
                    <div class="col-lg-6">
                        <div class="info d-flex align-items-center">
                            <div class="content">
                                <div class="logo">
                                    <h1>Login</h1>
                                </div>
                                <p>Fashion Archive Database</p>
                            </div>
                        </div>
                    </div>
                    <!-- Form Panel -->
                    <div class="col-lg-6 bg-white">
                        <div class="form d-flex align-items-center">
                            <div class="content">
                                <p class="text-warning">
                                    Your account is waiting for our administrator approval.<br>
                                    Please check back later.
                                </p>
                                <br>
                                Return to
                                <a id="logout" href="{{ route('logout') }}"  class="signup" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Login<form id="logout-form" action="{{ URL::action('Auth\LoginController@logout') }}" method="POST" style="display: none;">{{ csrf_field() }}</form>
                                </a>

                                    <br>
                                    <br>
                                New Account?
                                <a href="{{ URL::action('Panel\Settings\Auth\UserManagementController@register') }}" class="signup">Signup</a>

                                <br>Student Collection Related?
                                <a href="{{ URL::action('External\StudentCollectionController@register') }}" class="signup">Click here</a>

                                {{--
                                <br>LoanController?
                                <a href="{{ URL::action('Archive\LoanController@index') }}" class="signup">Click here</a>

                                <br>ReturnController?
                                <a href="{{ URL::action('Archive\ReturnController@index') }}" class="signup">Click here</a>
--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="copyrights text-center">
            <p>Design by <a href="https://bootstrapious.com" class="external">Bootstrapious</a></p>
            <!-- Please do not remove the backlink to us unless you support further theme's development at https://bootstrapious.com/donate. It is part of the license conditions. Thank you for understanding :) -->
        </div>
    </div>
@endsection