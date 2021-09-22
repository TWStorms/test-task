@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    {{--<div class="container">--}}
    <!-- Your code here -->
    @if(Auth::user()->status == \App\Helpers\IUserStatus::IN_ACTIVE)
        <div class="m-5">
            <h4 class="text-center">Please contact on this number <b>({{config('app.number')}})</b> and send registration code to activate your account</h4>
            <h4 class="text-center">Registration Code : <b>{{Auth::user()->registration_code}}</b></h4>
        </div>
    @endif
    <div class="container-fluid" style="{{Auth::user()->status != \App\Helpers\IUserStatus::ACTIVE ? 'filter: blur(20px)' : ''}};">
        <div class="row" style="height: 100vh;">
            <div class="col-md-2 col-lg-2 bg-purple px-0 d-md-block d-none " style="">
                @if(Auth::user()->status == \App\Helpers\IUserStatus::ACTIVE)
                    @include('supervisor.navbar')
                @endif
            </div>
            @if(Auth::user()->status == \App\Helpers\IUserStatus::ACTIVE)
                @include('admin.mobile-navbar')
            @endif
            <div class="col-md-10 col-lg-10 p-0 " style="" id="main-body">

                <!-- Main content area -->
                <main class="px-sm-4 px-2 pt-3">

                    <div class="row mt-2">

                        <!-- ./col -->
                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                            <!-- small box -->
                            <a href="{{route('supervisor.bloggers')}}" style="text-decoration: none;">
                                <div class="small-box text-white d-flex justify-content-between" id="box-2">
                                    @if(Auth::user()->status == \App\Helpers\IUserStatus::ACTIVE)
                                        <div class="inner pl-3">
                                            <h5>Bloggers</h5>

                                            <h4 class="m-0 my-1"><b>{{auth()->user()->subordinate ? count(auth()->user()->subordinate) : 0}}</b></h4>

                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-users" style="font-size: 70px; margin:10px 10px 0 0px; color: white; opacity: 20%;"></i>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                        <!-- ./col -->
                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                            <!-- small box -->
                            <a href="{{route('supervisor.blog')}}" style="text-decoration: none;">
                                <div class="small-box text-white text-left d-flex justify-content-between" id="box-3">
                                @if(Auth::user()->status == \App\Helpers\IUserStatus::ACTIVE)
                                    <div class="inner pl-3">
                                        <h5>Blogs</h5>

                                    </div>
                                    <div class="icon ">
                                        <i class="fas fa-chart-pie" style="font-size: 70px; margin:10px 10px 0 0px; color: white; opacity: 10%;"></i>
                                    </div>
                                @endif
                            </div>
                            </a>
                        </div>
                    </div>
                    <!-- /.row -->

                </main>
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
