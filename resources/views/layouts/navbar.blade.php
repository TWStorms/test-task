<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="col-md-2 text-center">
            <a class="navbar-brand" href="{{ url('/') }}">
                <div class="logo justify-content-center align-items-center">
                    <img src="{{asset('assets/images/MLM-Logo-2.png')}}" style="width: 100px;" alt="">
                </div>
            </a>
        </div>
        <div class="col-md-10">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('register-user') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li>
                            <div class="dropdown">
                                <div  class="user col align-self-end">
                                    <img src="{{ asset('assets/images/login_image.png') }}" id="userDropdown" alt="" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                        <div class="dropdown-header">
                                            <i class="i-Lock-User mr-1"></i> {!! __(Auth::user()->username) !!}
                                        </div>
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
