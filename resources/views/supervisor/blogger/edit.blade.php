@extends('layouts.app')
@section('title', 'Users')
@section('content')
    <div class="container-fluid" style="{{Auth::user()->status != \App\Helpers\IUserStatus::ACTIVE ? 'filter: blur(20px)' : ''}};">
        <div class="row" style="height: 100vh;">
            <div class="col-md-2 bg-purple px-0 d-md-block d-none " style="">
                @if(Auth::user()->status == \App\Helpers\IUserStatus::ACTIVE)
                    @include('admin.navbar')
                @endif
            </div>
            @if(Auth::user()->status == \App\Helpers\IUserStatus::ACTIVE)
                @include('admin.mobile-navbar')
            @endif

            <div class="col-md-10 card col" style="border: none; border-radius:20px; position: relative; margin-top: 10px;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card-header" style="border: none; background-color: mediumpurple;">
                            <h2 class="text-center" style="font-family: 'Nunito', sans-serif; color: white; background-color: mediumpurple;"><strong>{!! __('Edit User') !!}</strong></h2>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col render table-responsive">
                            @include('supervisor.blogger.partials.edit-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--</div>--}}
    <script>
        function activate()
        {
            $('#createSupervisor').modal('toggle');
        }
    </script>
    <script>
        /**
         * Show toaster for success or error messages
         *
         * @param type Type of toaster success or error.
         * @param msg  Message to be displayed in toaster.
         */
        const showToaster = (type, msg) => {

            if(msg === undefined)
                return;

            if (msg.length > 0) {
                switch (type) {
                    case 'success':
                        toastr.success(
                            msg,
                            {timeOut: "30000"}
                        );
                        break;
                    case 'error':
                        toastr.error(
                            msg,
                            {timeOut: "30000"}
                        );
                        break;
                }
            }
        };

        function copyToClipboard(elem) {
            /* Get the text field */
            var copyText = elem.attr('data-link');
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val(copyText).select();
            document.execCommand("copy");

            /* Alert the copied text */
            showToaster('success', "Link Copied");
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
