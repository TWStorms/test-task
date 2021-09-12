<div class="mb-3">
    {!! Form::open([
    'method' => 'get', 'class' => 'ajaxSearch', 'reset' => 'false',
     'url' => route('user.transactions')]) !!}
    <div>
        <div class="row">
            <div class="col-md-4 mt-3">
                {!! Form::text('transaction_id', null, ['id' => 'transaction_id', 'class' => 'form-control', 'placeholder' => __('Transaction Id')]) !!}
            </div>
            <div class="col-md-4 mt-3">
                {!! Form::select('method',['1' => 'Jazzcash', '2' => 'Easypaisa'], null, ['id' => 'method', 'class' => 'form-control', 'placeholder' => __('Method')]) !!}
            </div>
            {!! Form::hidden('user_id', auth()->id(), []) !!}
            {!! Form::hidden('withdrawal_request_status', null, []) !!}
            <div class="col-md-4 mt-3">
                {!! Form::select('transaction_type',[ '1' => 'credit', '2' => 'debit'], null, ['id' => 'transaction_type', 'class' => 'form-control', 'placeholder' => __('Transactiont Type')]) !!}
            </div>
            <div class="col-md-4 mt-3">
                <div class="row">
                    <div class="col-md-12 pr-0">
                        {!! Form::submit('Search', ['class' => 'btn btn-primary', 'style' => 'width:47%;color:white;background-color: mediumpurple;']) !!}
                        <a class="btn custom-reset-btn" style="color:white;background-color: mediumpurple;" href="{{ route('user.transactions') }}" style="width: 47%">
                            {!! __('Reset') !!}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
