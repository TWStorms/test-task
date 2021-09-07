<table class='table table-hover text-center my-1' id="aims360_products" style="border-color: black;width:100% !important;">
    <thead>
    <tr class="text-black">
        <td><strong>{!! __('Transaction Id') !!}</strong></td>
        <td><strong>{!! __('Method') !!}</strong></td>
        <td><strong>{!! __('Amount') !!}</strong></td>
        <td><strong>{!! __('Type') !!}</strong></td>
        <td><strong>{!! __('Status') !!}</strong></td>
        <td><strong>{!! __('Action') !!}</strong></td>
    </tr>
    </thead>
    <tbody>
    @if($transactions->count() > 0)
        @foreach($transactions as $key => $transaction)
            <tr>
                <td>{!! __($transaction->transaction_id) !!}</td>
                <td>
                    @if($transaction->method == \App\Helpers\ITransactionMethodTypes::JAZZCASH)
                        <img src="{{asset('assets/images/jazzcash.jpg')}}" width="30px;"> Jazzcash
                    @else
                        <img src="{{asset('assets/images/easypaisa.png')}}" width="30px;"> Easypaisa
                    @endif
                </td>
                <td>{!! __($transaction->amount) !!}</td>
                <td>{!! __($transaction->transaction_type === \App\Helpers\ITransactionMethodTypes::CREDIT ? '<span class="badge badge-success">credit</span>' : '<span class="badge badge-primary">debit</span>' ) !!}</td>
                <td>
                    @if($transaction->withdrawal_request_status === \App\Helpers\ITransactionMethodTypes::WITHDRAWAL_REQUEST_PENDING)
                        <span class="badge badge-primary">{!! __('Pending') !!}</span>
                    @elseif($transaction->withdrawal_request_status == \App\Helpers\ITransactionMethodTypes::WITHDRAWAL_REQUEST_DECLINED)
                        <span class="badge badge-danger">{!! __('Declined') !!}</span>
                    @elseif($transaction->withdrawal_request_status == \App\Helpers\ITransactionMethodTypes::WITHDRAWAL_REQUEST_APPROVED)
                        <span class="badge badge-success">{!! __('Approved') !!}</span>
                    @endif
                </td>
                <td>
                    <a href="{{route('sub-admin.withdrawal-request.approve', [$transaction->id])}}"><i class="far fa-check-circle" style="color: rebeccapurple; cursor: pointer;"></i></a>
                    <a href="{{route('sub-admin.withdrawal-request.decline', [$transaction->id])}}"><i class="far fa-times-circle" style="color: red; cursor: pointer;"></i></a>
                </td>
            </tr>
        @endforeach
    @else
        <tr><td colspan="10">{!! __('No Transactions Found.') !!}</td></tr>
    @endif
    </tbody>
</table>
<div class="page-link" style="float:left">
    {!! $transactions->links('pagination::bootstrap-4') !!}
</div>
