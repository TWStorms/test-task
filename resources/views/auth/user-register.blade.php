@extends('layouts.app')
@section('title', 'Register')
@section('content')
    <div class="auth-layout-wrap auth-layout-register backgroundimageset" style="background-image: url({{asset('assets/images/yacht1.jpg')}});">
        <div class="auth-content signup-card">
            <div class="container py-5 px-5 px-md-0">
                <div class="row">
                    <div class="col-md-4 d-sm-none d-none d-md-block d-lg-block banner-sec " style=" background-color: #F9FBF2; border-radius: 5% 0% 0% 5%; box-shadow: 1px 3px 5px rgb(0 0 0 / 20%) ;">
                        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                            <div class="carousel-item active" style="margin-top: 10px; background-color: #F9FBF2;">
                                <img class=" img-fluid d-flex justify-content-center align-content-center" src="{{asset('assets/images/login_image.png')}}" alt="First slide" style="padding-top: 4.5rem; padding-bottom: 2.5rem; "  />
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 login-sec rounded-sm py-4 px-5 screen_set"  style="background-color :rgb(139, 106, 250);   box-shadow: 1px 3px 5px rgb(0 0 0 / 20%);"   >
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

                        <form method="post" class="ajax" id="complete-user-signup" action="{{ route('create.user') }}"
                              autocomplete="off">
                            <h2 class="text-white">Sign Up</h2>
                            <p class="text-white">Please Fill In This Form To Sign Up An Account!</p>
                            <hr>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col py-2"><input type="text" class="form-control" name="username" placeholder="Username" required="required"></div>
                                    <div class="col py-2"><input type="email" class="form-control" name="email" placeholder="Email" required="required"></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col py-2"><input type="password" class="form-control" name="password" placeholder="Password" required="required"></div>
                                    <div class="col py-2"><input type="number" class="form-control" name="phone_number" placeholder="Phone Number" required="required"></div>
                                </div>
                            </div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col py-2"><input type="text" class="form-control" name="referer_username" placeholder="Reference Username" required="required"></div>
                                </div>
                            </div>
                            <div class="form-group text-white">
                                <label class="form-check-label"><input type="checkbox" required="required"> I accept the <a href="#" style="color: #F9FBF2;">Terms of Use</a> &amp; <a href="#" style="color: #F9FBF2;">Privacy Policy</a></label>
                                <div class="mt-2">
                                    <button type="submit" class="btn submit bg-white" style="color :rgb(139, 106, 250);"><b>Sign up</b></button>
                                </div>

                                <div class="form-check py-2 d-flex justify-content-md-end justify-content-center">
                                    <button type="button" class="btn btn-outline-white rounded-pill  text-white btn_forgot" data-mdb-ripple-color="dark" >
                                        Sign in <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-in-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M6 3.5a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v9a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 0-1 0v2A1.5 1.5 0 0 0 6.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-9A1.5 1.5 0 0 0 14.5 2h-8A1.5 1.5 0 0 0 5 3.5v2a.5.5 0 0 0 1 0v-2z"/>
                                            <path fill-rule="evenodd" d="M11.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H1.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </form>
                        <div class="text-white py-3">
                            Have An Account ? <a href="#" style="text-decoration: none; color: #F9FBF2;">Log In</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
