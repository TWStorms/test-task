@extends('layouts.app')
@section('title', 'User Profile')
@section('content')
    @if(Auth::user()->status == \App\Helpers\IUserStatus::IN_ACTIVE)
        <div class="m-5">
            <h4 class="text-center">Please contact on this number <b>({{config('app.number')}})</b> to activate your account</h4>
        </div>
    @endif
    <div class="container-fluid" style="{{Auth::user()->status != \App\Helpers\IUserStatus::ACTIVE ? 'filter: blur(20px)' : ''}};">
        <div class="row" style="height: 100vh;">
            <div class="col-md-2 bg-purple px-0 d-md-block d-none " style="">
                @if(Auth::user()->status == \App\Helpers\IUserStatus::ACTIVE)
                    @include(\App\Helpers\GeneralHelper::GET_ROLE(auth()->user()).'.navbar')
                @endif
            </div>
            <div class="col-md-10 p-0 bg-white " style="" id="main-body">
                <!--Wrapper-->

                <!-- Main content area -->
                <main class="px-sm-4 px-2 ">
                    <div class="card-header" style="border: none; background-color: mediumpurple;margin-top: 10px;">
                        <h4 class="text-center" style="font-family: 'Nunito', sans-serif; color: white; background-color: mediumpurple;"><strong>{{ucwords($user->username)}}</strong>
                            <small>
                                @if(\App\Helpers\GeneralHelper::IS_SUPER_ADMIN())
                                    (Super Admin)
                                @elseif(\App\Helpers\GeneralHelper::IS_SUB_ADMIN())
                                    (Sub Admin)
                                @elseif(\App\Helpers\GeneralHelper::IS_USER())
                                    (User)
                                @endif
                            </small>
                        </h4>
                        <p class="text-center" style="font-family: 'Nunito', sans-serif; color: white; background-color: mediumpurple;">Personal Information</p>
                    </div>
                    <div class="row" style="margin-top: 50px; padding: 30px;">
                        <div class="col-md-4 col-6">
                            <div class="mb-4" style="color: mediumpurple;">
                                <p class="mb-1"><i class="fa fa-user mr-1"></i>Username</p>
                                <span>{{!empty($user->username)? ucwords($user->username) : ''}}</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="mb-4" style="color: mediumpurple;">
                                <p class="mb-1"><i class="fa fa-mail-bulk mr-1"></i>Email</p>
                                <span>{{!empty($user->email)? ucwords($user->email) : ''}}</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="mb-4" style="color: mediumpurple;">
                                <p class="mb-1"><i class="fa fa-phone mr-1"></i>Phone Number</p>
                                <span>{{!empty($user->phone_number)? ucwords($user->phone_number) : ''}}</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="mb-4" style="color: mediumpurple;">
                                <p class="mb-1"><i class="fa fa-handshake mr-1"></i>Parent Username</p>
                                <span>{{!empty($user->parent)? ucwords($user->parent->username) : 'None'}}</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="mb-4" style="color: mediumpurple;">
                                <p class="mb-1"><i class="fa fa-layer-group mr-1"></i>Level Completed</p>
                                <span>{{!empty($user->level_completed)? ucwords($user->level_completed) : '0'}}</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="mb-4" style="color: mediumpurple;">
                                <p class=" mb-1"><i class="fa fa-child mr-1"></i>Child Count</p>
                                <span>{{!empty($user->child_count)? ucwords($user->child_count) : '0'}}</span>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="mb-4">
                                <p class="mb-1" style="color: mediumpurple;"><i class="i-Building text-16 mr-1"></i>Status</p>
                                    @if($user->verify === \App\Helpers\IUserStatus::VERIFIED)
                                        <span class="badge badge-success">verified</span>
                                    @endif
                                    @if($user->verify === \App\Helpers\IUserStatus::NOT_VERIFIED)
                                        <span class="badge badge-danger">un-verified</span>
                                    @endif
                                    @if($user->status === \App\Helpers\IUserStatus::ACTIVE)
                                        <span class="badge badge-success">active</span>
                                    @endif
                                    @if($user->status === \App\Helpers\IUserStatus::IN_ACTIVE)
                                        <span class="badge badge-danger">in-active</span>
                                    @endif</span>
                            </div>
                        </div>
                        @if(\App\Helpers\GeneralHelper::IS_USER())
                            <div class="col-md-4 col-6">
                                <div class="mb-4" style="color: mediumpurple;">
                                    <p class=" mb-1"><i class="fa fa-lock mr-1"></i>Change Password</p>
                                    <div onclick="changePassword({{$user->id}})"><i class="fa fa-edit mr-1" style="cursor: pointer;"></i></div>
                                </div>
                            </div>
                        @endif
                    </div>
                </main>
            </div>
        </div>
    </div>
    @if(\App\Helpers\GeneralHelper::IS_USER())
        @include('change-password-modal')
    @endif
    {{--</div>--}}
    <script>
        function changePassword(id)
        {
            $('#user_id').val(id);
            $('#changePassword').modal('toggle');
        }
    </script>
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
