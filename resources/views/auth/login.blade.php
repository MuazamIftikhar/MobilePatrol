@extends('layouts.app')

@section('content')
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-6 login-signin-on login-signin-on d-flex flex-row-fluid" id="kt_login">
            <div class="d-flex flex-column flex-lg-row flex-row-fluid text-center" style="background-image: url(assets/media/bg/bg-3.jpg);">
                <!--begin:Aside-->
                <div class="d-flex w-100 flex-center p-15">
                    <div class="login-wrapper">
                        <!--begin:Aside Content-->
                        <div class="text-dark-75">
                            <a href="#">
                                <img src="assets/media/logos/logo-letter-13.png" class="max-h-75px" alt="" />
                            </a>
                            <h3 class="mb-8 mt-22 font-weight-bold">JOIN OUR GREAT COMMUNITY</h3>
                            <p class="mb-15 text-muted font-weight-bold">The ultimate Bootstrap &amp; Angular 6 admin theme framework for next generation web apps.</p>
                            <button type="button" id="kt_login_signup" class="btn btn-outline-primary btn-pill py-4 px-9 font-weight-bold">Get An Account</button>
                        </div>
                        <!--end:Aside Content-->
                    </div>
                </div>
                <!--end:Aside-->
                <!--begin:Divider-->
                <div class="login-divider">
                    <div></div>
                </div>
                <!--end:Divider-->
                <!--begin:Content-->
                <div class="d-flex w-100 flex-center p-15 position-relative overflow-hidden bg-white">
                    <div class="login-wrapper">
                        <!--begin:Sign In Form-->
                        <div class="login-signin">
                            <div class="text-center mb-10 mb-lg-20">
                                <h2 class="font-weight-bold">Sign In</h2>
                                <p class="text-muted font-weight-bold">Enter your username and password</p>
                            </div>
                            <form class="form text-left" id="kt_login_signin_form" method="post" action="{{route('login')}}">
                                @csrf
                                <div class="form-group py-2 m-0">
                                    <input class="form-control h-auto border-0 px-0 placeholder-dark-75 @error('email') is-invalid @enderror" type="text"
                                           placeholder="Email" name="email" autocomplete="off" value="{{ old('email') }}" />
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group py-2 border-top m-0">
                                    <input class="form-control h-auto border-0 px-0 placeholder-dark-75 @error('password') is-invalid @enderror" type="Password" placeholder="Password" name="password" />
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="form-group d-flex flex-wrap justify-content-between align-items-center mt-5">
                                    <label class="checkbox m-0 text-muted font-weight-bold">
                                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />Remember me
                                        <span></span>
                                    </label>
                                </div>
                                <a href="javascript:;" id="kt_login_forgot" class="text-muted text-hover-primary font-weight-bold">Forget Password ?</a>

                                <div class="text-center mt-15">
                                    <button id="kt_login_signin_submit" class="btn btn-primary btn-pill shadow-sm py-4 px-9 font-weight-bold">Sign In</button>
                                </div>
                            </form>
                        </div>
                        <!--end:Sign In Form-->
                    </div>
                </div>
                <!--end:Content-->
            </div>
        </div>
        <!--end::Login-->
    </div>
@endsection
