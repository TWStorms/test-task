@extends('layouts.app')
@section('title', 'User')
@section('content')
    <!-- Your code here -->
    <div class="container-fluid" style="{{Auth::user()->status != \App\Helpers\IUserStatus::ACTIVE ? 'filter: blur(20px)' : ''}};">
        <div class="row" style="height: 100vh;">
            <div class="col-md-2 bg-purple px-0 d-md-block d-none " style="">
                @if(Auth::user()->status == \App\Helpers\IUserStatus::ACTIVE)
                    @include('supervisor.navbar')
                @endif
            </div>
            <div class="col-md-10 card col pt-4" style="border: none; border-radius:20px; position: relative; margin-top: 10px;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card-header" style="border: none; background-color: mediumpurple;">
                            <h2 class="text-center" style="font-family: 'Nunito', sans-serif; color: white; background-color: mediumpurple;"><strong>{!! __('Awaiting Users') !!}</strong></h2>
                        </div>
                    </div>
                </div>
{{--                <div>--}}
{{--                    <p>--}}
{{--                        <a class="btn ml-3 mt-3" style="color:white;background-color: mediumpurple;" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">--}}
{{--                            Filter--}}
{{--                        </a>--}}
{{--                    </p>--}}
{{--                    <div class="collapse" id="collapseExample">--}}
{{--                        <div class="card card-body" style="margin-left: 10px;">--}}
{{--                            @include("supervisor.blogger.partials.__filters")--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col-lg-12 render table-responsive ">
                            @include('supervisor.blogger.partials._listing')
                        </div>
                    </div>
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
