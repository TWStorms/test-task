@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
{{--<div class="container">--}}
    <!-- Your code here -->
    @if(Auth::user()->status == 0)
    <div class="m-5">
        <h4 class="text-center">Please contact on this number <b>({{config('app.number')}})</b> and send registration code to activate your account</h4>
        <h4 class="text-center">Registration Code : <b>{{Auth::user()->registration_code}}</b></h4>
    </div>
    @endif
    <div class="container-fluid" style="{{Auth::user()->status != 1 ? 'filter: blur(20px)' : ''}};">
        <div class="row" style="height: 100vh;">
            <div class="col-md-2 bg-purple px-0 d-md-block d-none " style="">
                @if(Auth::user()->status == 1)
                <div>
                    <ul class="text-white decoration-none list-unstyled py-3">
                        <li class="p-3 side-item active">
                            <a class="text-white d-flex " href="">
                                <div>
                                    <i class="fas fa-home"></i>
                                </div>
                                <div class="ml-2 res-text">Dashboard</div>
                            </a>
                        </li>

                        <li class="p-3 side-item ">
                            <a class="text-white d-flex " href="">
                                <div>
                                    <i class="fas fa-user-alt"></i>
                                </div>
                                <div class="ml-2 res-text">My Profile</div>
                            </a>
                        </li>
                        <li class="p-3 side-item">
                            <a class="text-white d-flex " href="#">
                                <div>
                                    <i class="fas fa-network-wired"></i>
                                </div>
                                <div class="ml-2 res-text">My Network</div>
                            </a>
                        </li>
                        <li class="p-3 side-item">
                            <a class="text-white d-flex " href="#">
                                <div>
                                    <i class="fas fa-pound-sign"></i>
                                </div>
                                <div class="ml-2 res-text">Transactions</div>
                            </a>

                        </li>
                        <li class="p-3 side-item">
                            <a class="text-white d-flex" href="#">
                                <div>
                                    <i class="fas fa-briefcase"></i>
                                </div>
                                <div class="ml-2 res-text">Wallet</div>
                            </a>
                        </li>
                        <li class="p-3 side-item">
                            <a class="text-white d-flex " href="{{route('logout')}}">
                                <div>
                                    <i class="fas fa-sign-out-alt"></i>
                                </div>
                                <div class="ml-2 res-text">Logout</div>
                            </a>
                        </li>
                    </ul>
                </div>
                @endif
            </div>
            <div class="col-md-10 p-0 " style="" id="main-body">
                <div class="Wrapper bg-purple d-md-none">
                    <aside class="sidebar ">

                        <!-- mobile screen sidebar logo -->
                        <div class="logo-wrapper bg-white d-flex justify-content-center align-items-center">
                            <div class="logo ">
                                <img src="./src/assets/MLM-Logo-2.png" style="width: 120px;" alt="">
                            </div>
                        </div>

                        <ul class="text-white decoration-none list-unstyled py-3">
                            <li class="p-3 side-item active">
                                <a class="text-white d-flex " href="">
                                    <div>
                                        <i class="fas fa-home text-white mr-2" ></i>
                                    </div>
                                    <div class="ml-3">Dashboard</div>
                                </a>
                            </li>
                            <li class="p-3 side-item" >
                                <a class="text-white d-flex " href="">
                                    <div>
                                        <i class="fas fa-user-circle"></i>
                                    </div>
                                    <div class="ml-3">My Account</div>
                                </a>
                            </li>

                            <li class="p-3 side-item">
                                <a class="text-white d-flex " href="#">
                                    <div>
                                        <i class="fas fa-network-wired"></i>
                                    </div>
                                    <div class="ml-3">My Network</div>
                                </a>

                            </li>
                            <li class="p-3 side-item">
                                <a class="text-white d-flex " href="#">
                                    <div>
                                        <i class="fas fa-pound-sign"></i>
                                    </div>
                                    <div class="ml-3">Transactions</div>
                                </a>
                            </li>

                            <li class="p-3 side-item">
                                <a class="text-white d-flex " href="#">
                                    <div>
                                        <i class="fas fa-briefcase"></i>
                                    </div>
                                    <div class="ml-3">Wallet</div>
                                </a>
                            </li>
                            <li class="p-3 side-item" >
                                <a class="text-white d-flex " href="">
                                    <div>
                                        <i class="fas fa-user-alt"></i>
                                    </div>
                                    <div class="ml-3">My Profile</div>
                                </a>
                            </li>
                            <li class="p-3 side-item">
                                <a class="text-white d-flex " href="#">
                                    <div>
                                        <i class="fas fa-sign-out-alt"></i>
                                    </div>
                                    <div class="ml-3">Logout</div>
                                </a>
                            </li>
                        </ul>


                    </aside>
                    <div class="overlay"></div>
                </div>
                <!--Wrapper-->

                <!-- Main content area -->
                <main class="px-sm-4 px-2">

                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-6 col-12 on-hover">
                            <!-- small box -->
                            <div class="small-box text-left d-flex justify-content-between" id="box-1">
                                @if(Auth::user()->status == 1)
                                <div class="inner text-white pl-3">
                                    <h5>My Account</h5>

                                    <p class="m-0 my-1">Package: Starter</p>

                                </div>
                                <div class="icon">
                                    <i class="fas fa-chart-bar" style="font-size: 70px; margin:10px 10px 0 0; color: white; opacity: 20%;"></i>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- small box -->
                            <div class="small-box text-white d-flex justify-content-between" id="box-2">
                                @if(Auth::user()->status == 1)
                                <div class="inner pl-3">
                                    <h5>i100 Account</h5>

                                    <p class="m-0 my-1">open: 61.065571</p>

                                </div>
                                <div class="icon ">
                                    <i class="fas fa-chart-pie" style="font-size: 70px; margin:10px 10px 0 0px; color: white; opacity: 10%;"></i>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- small box -->
                            <div class="small-box text-white text-left d-flex justify-content-between" id="box-3">
                                @if(Auth::user()->status == 1)
                                <div class="inner pl-3">
                                    <h5>i100 Price</h5>

                                    <p class="m-0 my-1">Price 61.00P</p>

                                </div>
                                <div class="icon">
                                    <i class="fas fa-users" style="font-size: 70px; margin:10px 10px 0 0px; color: white; opacity: 20%;"></i>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- small box -->
                            <div class="small-box text-left d-flex justify-content-between" id="box-4">
                                @if(Auth::user()->status == 1)
                                <div class="inner text-white pl-3">
                                    <h5>Total Bonus</h5>

                                    <p class="m-0 my-1">Last Week: £0.00</p>

                                </div>
                                <div class="icon">
                                    <i class="fas fa-percent" style="font-size: 70px; margin:10px 20px 0 0px; color: white; opacity: 20%;"></i>
                                </div>
                                @endif
                            </div>
                        </div>
                        <!-- ./col -->
                    </div>
                    <!-- /.row -->

                </main>
                <div class=" px-0 col-12 footer-div d-flex justify-content-center align-items-center">
                    <footer class="">
                        <p class="mb-0">Copyright &copy; 2021 all rights reserved</p </footer>
                </div>
            </div>

        </div>

    </div>
    {{--</div>--}}
@endsection

@section('page-js')
<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Popper JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<!-- JavaScript Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-U1DAWAznBHeqEIlVSCgzq+c9gqGAJn5c/t99JyeKa9xxaYpSvHU5awsuZVVFIhvj"
        crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/6b261b503b.js" crossorigin="anonymous"></script>
<script src="./js/index.js"></script>
<!-- additional link -->
@endsection
