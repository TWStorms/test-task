<div class="modal fade" id="createSupervisor" tabindex="-1" role="dialog" aria-labelledby="createSupervisorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createSupervisorModalLabel">Create Supervisor</h5>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => route('admin.supervisor.create'), 'method' => 'post', 'id' => 'activate-blogger', 'class' => 'ajax']) !!}
                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                        <label for="first_name">
                            First Name<span class="text-danger">*</span>
                        </label>

                        {!! Form::text(
                            'first_name',
                            null,
                            [
                                'class' => 'form-control form-control-rounded',
                                'id' => 'first_name',
                                'placeholder' => 'First Name',
                                'required' => 'required'
                            ]
                        ) !!}
                        <div class="form-error first_name"></div>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="last_name">
                            Last Name<span class="text-danger">*</span>
                        </label>

                        {!! Form::text(
                            'last_name',
                            null,
                            [
                                'class' => 'form-control form-control-rounded',
                                'id' => 'last_name',
                                'placeholder' => 'Last Name',
                                'required' => 'required'
                            ]
                        ) !!}
                        <div class="form-error last_name"></div>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="email">
                            Email<span class="text-danger">*</span>
                        </label>

                        {!! Form::text(
                            'email',
                            null,
                            [
                                'class' => 'form-control form-control-rounded',
                                'id' => 'email',
                                'placeholder' => 'Email',
                                'required' => 'required'
                            ]
                        ) !!}
                        <div class="form-error email"></div>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="password">
                            Password<span class="text-danger">*</span>
                        </label>

                        {!! Form::password(
                            'password',
                            [
                                'class' => 'form-control form-control-rounded',
                                'id' => 'password',
                                'placeholder' => 'Password',
                                'required' => 'required'
                            ]
                        ) !!}
                        <div class="form-error password"></div>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="email">
                            Assign Bloggers<span class="text-danger">*</span>
                        </label>
                        <select class="form-control form-control-rounded" name="bloggers[]" multiple id="bloggers">
                            @foreach($users as $user)
                                @if(\App\Helpers\GeneralHelper::GET_ROLE($user) != 'admin')
                                    <option value="{{$user->id}}">{{$user->first_name}} {{$user->last_name}}</option>
                                @endif
                            @endforeach
                        </select>
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
