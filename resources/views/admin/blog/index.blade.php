@extends('layouts.app')
@section('title', 'Blogs')
@section('content')
    <div class="container-fluid" style="{{Auth::user()->status != \App\Helpers\IUserStatus::ACTIVE ? 'filter: blur(20px)' : ''}};">
        <div class="row" style="height: 70vh;">
            <div class="col-md-2 bg-purple px-0 d-md-block d-none " style="">
                @if(Auth::user()->status == \App\Helpers\IUserStatus::ACTIVE)
                    @include('supervisor.navbar')
                @endif
            </div>
            <div class="col-md-10 card col pt-4" style="border: none; border-radius:20px; position: relative; margin-top: 10px;">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="card-header" style="border: none; background-color: mediumpurple;">
                            <h2 class="text-center" style="font-family: 'Nunito', sans-serif; color: white; background-color: mediumpurple;"><strong>{!! __('Blogs') !!}</strong></h2>
                        </div>
                    </div>
                </div>
                <div class="mt-2">
                    <a class="btn text-white" style="background-color: mediumpurple;" onclick="createBlog()">Create Blogs</a>
                </div>

                <div class="card-body">
                    <div class="row justify-content-center">
                        <div class="col render table-responsive">
                            @include('supervisor.blog.partials._listing')
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="modal fade" id="createBlog" tabindex="-1" role="dialog" aria-labelledby="createBlogModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createBlogModalLabel">Create Blog</h5>
                </div>
                <div class="modal-body">
                    {!! Form::open(['url' => route('supervisor.blog.create'), 'method' => 'post', 'id' => 'create-blog', 'class' => 'ajax']) !!}
                    <div class="row">
                        <div class="col-md-12 form-group mb-3">
                            <label for="name">
                                Name<span class="text-danger">*</span>
                            </label>

                            {!! Form::text(
                                'name',
                                null,
                                [
                                    'class' => 'form-control form-control-rounded',
                                    'id' => 'name',
                                    'placeholder' => 'Name',
                                    'required' => 'required'
                                ]
                            ) !!}
                            <div class="form-error name"></div>
                        </div>
                        <div class="col-md-12 form-group mb-3">
                            <label for="description">
                                Description<span class="text-danger">*</span>
                            </label>

                            {!! Form::textarea(
                                'description',
                                null,
                                [
                                    'class' => 'form-control form-control-rounded',
                                    'id' => 'description',
                                    'placeholder' => 'Description',
                                    'required' => 'required'
                                ]
                            ) !!}
                            <div class="form-error description"></div>
                        </div>
                        <div class="row mt-3 col-md-12">
                            <div class="col">
                                <button type="submit" class="btn btn-rounded submit" style="background-color: rebeccapurple; color: white;">Create</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>

    {{--</div>--}}
    <script>
        function createBlog()
        {
            $('#createBlog').modal('toggle');
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
