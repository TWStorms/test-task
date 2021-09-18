<div class="modal fade" id="changePassword" tabindex="-1" role="dialog" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Change Password</h5>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => route('user.change-password'), 'method' => 'post', 'id' => 'change-password']) !!}
                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                        <label for="old_password">
                            Old Password<span class="text-danger">*</span>
                        </label>

                        {!! Form::password(
                            'old_password',
                            [
                                'class' => 'form-control form-control-rounded',
                                'id' => 'old_password',
                                'placeholder' => 'Old Password',
                                'required' => 'required'
                            ]
                        ) !!}
                        <div class="form-error old_password"></div>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="new_password">
                            New Password<span class="text-danger">*</span>
                        </label>

                        {!! Form::password(
                            'new_password',
                            [
                                'class' => 'form-control form-control-rounded',
                                'id' => 'new_password',
                                'placeholder' => 'New Password',
                                'required' => 'required'
                            ]
                        ) !!}
                        <div class="form-error new_password"></div>
                    </div>
                    <div class="col-md-12 form-group mb-3">
                        <label for="confirm_password">
                            Confirm Password<span class="text-danger">*</span>
                        </label>

                        {!! Form::password(
                            'confirm_password',
                            [
                                'class' => 'form-control form-control-rounded',
                                'id' => 'confirm_password',
                                'placeholder' => 'Confirm Password',
                                'required' => 'required'
                            ]
                        ) !!}
                        <div class="form-error confirm_password"></div>
                    </div>
                    {{Form::hidden('user_id', '', ['id' => 'user_id'])}}
                    <div class="row mt-3 col-md-12">
                        <div class="col">
                            <button type="submit" class="btn btn-rounded submit" style="background-color: rebeccapurple; color: white;">Change</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
