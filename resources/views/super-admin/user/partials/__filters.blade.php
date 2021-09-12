<div class="mb-3">
    {!! Form::open([
    'method' => 'get', 'class' => 'ajaxSearch', 'reset' => 'false',
     'url' => route('super-admin.users')]) !!}
    <div>
        <div class="row">
            <div class="col-md-4 mt-3">
                {!! Form::text('username', null, ['id' => 'username', 'class' => 'form-control', 'placeholder' => __('Username')]) !!}
            </div>
            <div class="col-md-4 mt-3">
                {!! Form::email('email', null, ['id' => 'email', 'class' => 'form-control', 'placeholder' => __('Email')]) !!}
            </div>
            <div class="col-md-4 mt-3">
                {!! Form::number('phone_number', null, ['id' => 'phone_number', 'class' => 'form-control', 'placeholder' => __('Phone Number')]) !!}
            </div>
            <div class="col-md-4 mt-3">
                {!! Form::select('status',['2' => 'Active', '1' => 'In-Active'], null, ['id' => 'status', 'class' => 'form-control', 'placeholder' => __('Active Status')]) !!}
            </div>
            {!! Form::hidden('parent_id', auth()->id(), []) !!}

            <div class="col-md-4 mt-3">
                <div class="row">
                    <div class="col-md-12 pr-0">
                        {!! Form::submit('Search', ['class' => 'btn btn-primary', 'style' => 'width:47%;color:white;background-color: mediumpurple;']) !!}
                        <a class="btn custom-reset-btn" style="color:white;background-color: mediumpurple;" href="{{ route('super-admin.users') }}" style="width: 47%">
                            {!! __('Reset') !!}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
</div>
