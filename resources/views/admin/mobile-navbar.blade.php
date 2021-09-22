<!-- mobile screen sidebar -->
<div class="Wrapper bg-purple d-md-none">
    <aside class="sidebar ">

        <!-- mobile screen sidebar logo -->
        <div class="logo-wrapper bg-white d-flex justify-content-center align-items-center">
            <div class="logo ">
                <img src="{{asset('assets/images/logo1.png')}}" width="100" height="60" alt="">
            </div>
        </div>

        <ul class="text-white decoration-none list-unstyled py-3">
            <li class="p-3 side-item active">
                <a class="text-white d-flex " href="{{route('admin.dashboard')}}">
                    <div>
                        <i class="fas fa-home"></i>
                    </div>
                    <div class="ml-2 res-text">Dashboard</div>
                </a>
            </li>

            <li class="p-3 side-item ">
                <a class="text-white d-flex " href="{{route('admin.profile')}}">
                    <div>
                        <i class="fas fa-blogger-alt"></i>
                    </div>
                    <div class="ml-2 res-text">My Profile</div>
                </a>
            </li>
        </ul>
    </aside>
    <div class="overlay"></div>
</div>
