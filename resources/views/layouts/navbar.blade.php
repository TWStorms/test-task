<div id="app">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top bg-light" style="z-index: 1">

        <div class="container-fluid pl-5 pr-5">
            <a class="navbar-brand" href="{{ url('/') }}">
                <strong>Blog</strong>
            </a>
            <button id="icon" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
<!--            id="navbarSupportedContent"-->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link btn btn-outline-success rounded-pill me-2  btn_wohover btn_hover" href="{{ route('login') }}">{{ __('LogIn') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-outline-success rounded-pill me-2  btn_wohover btn_hover" href="{{ url('register-user') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li>
                            <div class="dropdown">
                                <div  class="user col align-self-end">
                                    <img src="{{ asset('assets/images/login_image.png') }}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                        <div class="dropdown-header">
                                            <i class="i-Lock-User mr-1"></i> {!! __(Auth::user()->first_name) !!}
                                        </div>
                                        <a class="dropdown-item" href="{{ route(\App\Helpers\GeneralHelper::GET_ROLE(auth()->user()).'.dashboard') }}">{!! __('Dashboard') !!}</a>
                                        <a class="dropdown-item" href="{{ route('logout') }}">{!! __('Logout') !!}</a>
                                    </div>
                                </div>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</div>
