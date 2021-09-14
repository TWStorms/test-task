@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    {{--<div class="container">--}}
    <!-- Your code here -->
    <div class="container-fluid">
        <div class="row" style="height: 100vh;">
            <div class="col-md-2 bg-purple px-0 d-md-block d-none " style="">
                @include('super-admin.navbar')
            </div>
            <div class="col-md-10 p-0 " style="" id="main-body">
                <!--Wrapper-->

                <!-- Main content area -->
                <main class="px-sm-4 px-2">

                    <div class="row mt-2">
                        <div class="col-lg-3 col-md-6 col-12 on-hover">
                            <!-- small box -->
                            <a href="{{route('super-admin.users')}}" style="text-decoration: none;">
                                <div class="small-box text-left d-flex justify-content-between" id="box-1">
                                    @if(Auth::user()->status == \App\Helpers\IUserStatus::ACTIVE)
                                        <div class="inner text-white pl-3">
                                            <h5>Users</h5>

                                            <p class="m-0 my-1">{{$userCount ?? 0}}</p>

                                        </div>
                                        <div class="icon">
                                            <i class="fas fa-users" style="font-size: 70px; margin:10px 10px 0 0; color: white; opacity: 20%;"></i>
                                        </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- small box -->
                            <div class="small-box text-white d-flex justify-content-between" id="box-2">
                                @if(Auth::user()->status == \App\Helpers\IUserStatus::ACTIVE)
                                    <div class="inner pl-3">
                                        <h5>Wallet</h5>

                                        <p class="m-0 mt-2">Rs {!! __(auth()->user()->wallet ? auth()->user()->wallet->amount : 0) !!}</p>
                                        <p class="m-0 mt-2">Level {!! __(auth()->user()->level_completed) !!}</p>

                                    </div>
                                    <div class="icon ">
                                        <i class="fas fa-coins" style="font-size: 70px; margin:10px 10px 0 0px; color: white; opacity: 10%;"></i>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- small box -->
                            <a href="{{route('super-admin.transactions')}}" style="text-decoration: none;">
                                <div class="small-box text-white text-left d-flex justify-content-between" id="box-3">
                                @if(Auth::user()->status == \App\Helpers\IUserStatus::ACTIVE)
                                    <div class="inner pl-3">
                                        <h5>Transactions</h5>

                                        <p class="m-0 my-1">{{ $transactionCount ?? 0 }}</p>

                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-chart-bar" style="font-size: 70px; margin:10px 10px 0 0px; color: white; opacity: 20%;"></i>
                                    </div>
                                @endif
                            </div>
                            </a>
                        </div>
                        <!-- ./col -->
                        <div class="col-lg-3 col-md-6 col-12">
                            <!-- small box -->
                            <a href="{{route('super-admin.map', [auth()->user()->username])}}" style="text-decoration: none;">
                                <div class="small-box text-left d-flex justify-content-between" id="box-4">
                                @if(Auth::user()->status == \App\Helpers\IUserStatus::ACTIVE)
                                    <div class="inner text-white pl-3">
                                        <h5>My Network</h5>
                                    </div>
                                    <div class="icon">
                                        <i class="fas fa-network-wired" style="font-size: 70px; margin:10px 20px 0 0px; color: white; opacity: 20%;"></i>
                                    </div>
                                @endif
                            </div>
                            </a>
                        </div>
                        <!-- ./col -->
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
