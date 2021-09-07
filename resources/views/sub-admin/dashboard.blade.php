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
                    @include('sub-admin.navbar')
                @endif
            </div>
            <div class="col-md-10 p-0 " style="" id="main-body">

                <!-- Main content area -->
                <main class="px-sm-4 px-2">

                    <div class="row mt-2">

                        <!-- ./col -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- small box -->
                            <a href="{{route('sub-admin.awaiting-approval')}}" style="text-decoration: none;">
                                <div class="small-box text-white d-flex justify-content-between" id="box-2">
                                    @if(Auth::user()->status == 1)
                                        <div class="inner pl-3">
                                            <h5>Awaiting Approval</h5>

                                            <h4 class="m-0 my-1"><b>{{$count ?? 0}}</b></h4>

                                        </div>
                                        <div class="icon ">
                                            <i class="fas fa-chart-pie" style="font-size: 70px; margin:10px 10px 0 0px; color: white; opacity: 10%;"></i>
                                        </div>
                                    @endif
                                </div>
                            </a>
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
