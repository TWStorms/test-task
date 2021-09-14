@extends('layouts.app')
@section('title', 'Login')
@section('content')
    <div class="auth-layout-wrap auth-layout-register">
        <div class="auth-content signup-card">
            <div class="container py-5 px-5 px-md-0" >
                <div class="row">
                    <div class="col-md-4 d-sm-none d-none d-md-block d-lg-block banner-sec  " style="border-radius: 5% 0% 0% 5%; background-color: #F9FBF2;">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <div class="carousel-item active bg-light">
                                <img class=" img-fluid d-flex justify-content-center align-content-center  " src="{{asset('assets/images/login_image.png')}}" alt="First slide" style="padding-top: 4.5rem; padding-bottom: 2.5rem; "  />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 login-sec py-4 px-5 screen_set"  style="background-color :rgb(139, 106, 250);   box-shadow: 1px 3px 5px rgb(0 0 0 / 10%); " >
                        <h2 class="text-center text-white">
                            <p class="heading_style">
                                Welcome to Al-Aman Traders
                                <sup>&#174;</sup>
                            </p>
                        </h2>
                        <br/>
                        <p class="text-center text-white">
                            Become a part of our community and <br />
                            learn new things everyday.
                        </p>
                        <form method="post" class="ajax" id="login-user" action="{{ route('login.user') }}"
                              autocomplete="off">
                            @csrf

                            <h2 class="text-white">Sign In</h2>
                            <p class="text-white">Please Fill In This Form To Sign Up An Account!</p>
                            <hr>
                            <div class="form-group">
                                <label for="email" class="text-uppercase"></label>
                                <input type="email" class="form-control" name="email" placeholder="Email" style = "border:3px solid #7665bf " />
                            </div>
                            <div class="form-group">
                                <label for="password" class="text-uppercase"></label>
                                <input type="password" class="form-control" name="password" placeholder="Password" style = "border:3px solid #7665bf"/>
                            </div>

                            <div class="mt-2">
                                <button type="submit" class="btn submit bg-white" style="color :rgb(139, 106, 250);"><b>Login</b></button>
                            </div>

                            <div class="form-check py-2 d-flex justify-content-md-end justify-content-center">
                                <button type="button" class="btn btn-outline-white rounded-pill  text-white btn_forgot" data-mdb-ripple-color="dark" >
                                    login <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                                        <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                        <div class="text-white py-3">
                            <a href="#" class="btn btn-lg btn_forgot" style="text-decoration: none; color: #F9FBF2;">
                                Forgot Password?
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
