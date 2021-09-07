<div class="modal fade" id="withdrawAmountModal" tabindex="-1" role="dialog" aria-labelledby="withdrawAmountModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="withdrawAmountModalLabel">Withdraw Amount</h5>
            </div>
            <div class="modal-body">
                {!! Form::open(['url' => route(\App\Helpers\GeneralHelper::GET_ROLE(auth()->user()).'.withdraw-request'), 'method' => 'post', 'id' => 'withdraw-amount']) !!}
                <div class="row">
                    <div class="col-md-12 form-group mb-3">
                        <label for="phone_number">
                            Number<span class="text-danger">*</span>
                        </label>

                        {!! Form::text(
                            'phone_number',
                            null,
                            [
                                'class' => 'form-control form-control-rounded',
                                'id' => 'phone_number',
                                'placeholder' => 'Number',
                                'required' => 'required'
                            ]
                        ) !!}
                        <div class="form-error phone_number"></div>
                    </div>
                    {{Form::hidden('userId', auth()->id(), [])}}
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
                    <div class="col-md-12 form-group mb-3">
                        <label for="amount">
                            Amount<span class="text-danger">*</span>
                        </label>

                        {!! Form::text(
                            'amount',
                            null,
                            [
                                'class' => 'form-control form-control-rounded',
                                'id' => 'amount',
                                'placeholder' => 'Amount',
                                'required' => 'required'
                            ]
                        ) !!}
                        <div class="form-error amount"></div>
                    </div>
                    <div class="row mt-3 col-md-12">
                        <div class="col">
                            <button type="submit" class="btn btn-rounded submit" style="background-color: rebeccapurple; color: white;">Send Request</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
<script>
    $("body").on("form-success-event", "#withdraw-amount", function (event, data) {
        location.href = window.location.href;
    });
</script>
