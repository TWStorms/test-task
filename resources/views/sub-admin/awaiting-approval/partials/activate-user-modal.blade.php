<div class="modal fade" id="activateUser" tabindex="-1" role="dialog" aria-labelledby="activateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="activateUserModalLabel">Activate User</h5>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => route(\App\Helpers\GeneralHelper::GET_ROLE(auth()->user()).'.user-activate'), 'method' => 'post', 'id' => 'activate-user', 'class' => 'ajax']) !!}
                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                        <label for="transaction_id">
                            Transation Id<span class="text-danger">*</span>
                        </label>

                        {!! Form::text(
                            'transaction_id',
                            null,
                            [
                                'class' => 'form-control form-control-rounded',
                                'id' => 'transaction_id',
                                'placeholder' => 'Transaction Id',
                                'required' => 'required'
                            ]
                        ) !!}
                        <div class="form-error transaction_id"></div>
                    </div>
                    {{Form::hidden('userId', '', ['id' => 'userId'])}}
                    <div class="col-md-12 form-group mb-3">
                        <label for="transaction_method">
                            Transaction Method<span class="text-danger">*</span>
                        </label>
                        {!! Form::select(
                            'transaction_method',
                            ['1' => 'Easypaisa', '2' => 'Jazzcash'],
                            null ,
                            [
                                'class' => 'form-control form-control-rounded',
                                'id' => 'transaction_method',
                                'placeholder' => 'Select Method',
                                'required' => 'required'
                            ]
                        ) !!}
                        <div class="form-error transaction_method"></div>
                    </div>
                    <div class="row mt-3 col-md-12">
                        <div class="col">
                            <button type="submit" class="btn btn-rounded submit" style="background-color: rebeccapurple; color: white;">Activate</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
