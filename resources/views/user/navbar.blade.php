<div>
    <ul class="text-white decoration-none list-unstyled py-3">
        <li class="p-3 side-item active">
            <a class="text-white d-flex " href="{{route('user.dashboard')}}">
                <div>
                    <i class="fas fa-home"></i>
                </div>
                <div class="ml-2 res-text">Dashboard</div>
            </a>
        </li>

        <li class="p-3 side-item ">
            <a class="text-white d-flex " href="{{route('user.profile')}}">
                <div>
                    <i class="fas fa-user-alt"></i>
                </div>
                <div class="ml-2 res-text">My Profile</div>
            </a>
        </li>
        <li class="p-3 side-item">
            <a class="text-white d-flex " href="{{route('user.map',[auth()->user()->username])}}">
                <div>
                    <i class="fas fa-network-wired"></i>
                </div>
                <div class="ml-2 res-text">My Network</div>
            </a>
        </li>
        <li class="p-3 side-item">
            <a class="text-white d-flex " href="{{route('user.withdrawal-requests')}}">
                <div>
                    <i class="fas fa-pound-sign"></i>
                </div>
                <div class="ml-2 res-text">Withdrawal Requests</div>
            </a>
        </li>
        <li class="p-3 side-item">
            <a class="text-white d-flex " href="{{route('user.transactions')}}">
                <div>
                    <i class="fas fa-chart-bar"></i>
                </div>
                <div class="ml-2 res-text">Transaction</div>
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
