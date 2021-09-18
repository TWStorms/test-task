@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <link href="{{ asset('css/company.css') }}" rel="stylesheet">
    <div class="container py-3">
        <div class="title h1 text-center"><b>AL-AMAN TRADERS PRIVATE POLICIES</b></div>
        <!-- Card Start -->
        <div class="card">
            <div class="row ">

                <div class="col-md-7 px-3">
                    <div class="card-block px-6">
                        <h4 class="card-title">Private Policies</h4>
                        <p class="card-text">
                            Can be replaced with an img src, no problem. The CSS brings shadow to the card and some adjustments to the prev/next buttons and the indicators is rounded now.
                        </p>
                        <p class="card-text">Made for usage, commonly searched for. Fork, like and use it. Just move the carousel div above the col containing the text for left alignment of images</p>

                        <p class="card-text">Made for usage, commonly searched for. Fork, like and use it. Just move the carousel div above the col containing the text for left alignment of images</p>

                        <p class="card-text">Made for usage, commonly searched for. Fork, like and use it. Just move the carousel div above the col containing the text for left alignment of images</p>
                        <br>
                    </div>
                </div>
                <!-- Carousel start -->
                <div class="col-md-5">
                    <div id="CarouselTest" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#CarouselTest" data-slide-to="0" class="active"></li>
                            <li data-target="#CarouselTest" data-slide-to="1"></li>
                            <li data-target="#CarouselTest" data-slide-to="2"></li>

                        </ol>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img class="d-block" src="https://picsum.photos/450/300?image=1072" alt="">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block" src="https://picsum.photos/450/300?image=855" alt="">
                            </div>
                            <div class="carousel-item">
                                <img class="d-block" src="https://picsum.photos/450/300?image=355" alt="">
                            </div>
                            <a class="carousel-control-prev" href="#CarouselTest" role="button" data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#CarouselTest" role="button" data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- End of carousel -->
            </div>
        </div>
        <!-- End of card -->

    </div>

    {{--    <div class="container">--}}
    {{--        <div class="card float-left">--}}
    {{--            <div class="row ">--}}

    {{--                <div class="col-sm-7">--}}
    {{--                    <div class="card-block">--}}
    {{--                        <!--           <h4 class="card-title">Small card</h4> -->--}}
    {{--                        <p>Wetgple text to build your own card.</p>--}}
    {{--                        <p>Change around the content for awsomenes</p>--}}
    {{--                        <a href="#" class="btn btn-primary btn-sm">Read More</a>--}}
    {{--                    </div>--}}
    {{--                </div>--}}

    {{--                <div class="col-sm-5">--}}
    {{--                    <img class="d-block w-100" src="https://picsum.photos/150?image=380" alt="">--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}


    {{--        <div class="card float-right">--}}
    {{--            <div class="row">--}}
    {{--                <div class="col-sm-5">--}}
    {{--                    <img class="d-block w-100" src="https://picsum.photos/150?image=641" alt="">--}}
    {{--                </div>--}}
    {{--                <div class="col-sm-7">--}}
    {{--                    <div class="card-block">--}}
    {{--                        <!--           <h4 class="card-title">Small card</h4> -->--}}
    {{--                        <p>Copy paste the HTML and CSS.</p>--}}
    {{--                        <p>Change around the content for awsomenes</p>--}}
    {{--                        <br>--}}
    {{--                        <a href="#" class="btn btn-primary btn-sm float-right">Read More</a>--}}
    {{--                    </div>--}}
    {{--                </div>--}}

    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}

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
