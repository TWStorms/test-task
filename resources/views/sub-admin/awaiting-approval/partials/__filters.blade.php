<div class="mb-3">
    {!! Form::open([
    'method' => 'get', 'class' => 'ajaxSearch', 'reset' => 'false',
     'url' => route('sub-admin.awaiting-approval')]) !!}
    <div>
        <div class="row">
            <div class="col-md-4 mt-3">
                {!! Form::text('username', null, ['id' => 'username', 'class' => 'form-control', 'placeholder' => __('Username'), 'required']) !!}
            </div>
            <div class="col-md-4 mt-3">
                <div class="row">
                    <div class="col-md-12 pr-0">
                        {!! Form::submit('Search', ['class' => 'btn btn-primary', 'style' => 'width:47%;color:white;background-color: mediumpurple;']) !!}
                        <a class="btn custom-reset-btn" style="color:white;background-color: mediumpurple;" href="{{ route('sub-admin.awaiting-approval') }}" style="width: 47%">
                            {!! __('Reset') !!}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
