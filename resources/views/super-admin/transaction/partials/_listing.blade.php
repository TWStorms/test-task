<table class='table table-hover text-center my-1' id="aims360_products" style="border-color: black;width:100% !important;">
    <thead>
    <tr class="text-black">
        <td><strong>{!! __('Transaction Id') !!}</strong></td>
        <td><strong>{!! __('Method') !!}</strong></td>
        <td><strong>{!! __('Amount') !!}</strong></td>
        <td><strong>{!! __('Type') !!}</strong></td>
        <td><strong>{!! __('Date') !!}</strong></td>
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
                <td>{!! __(\Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y H:i')) !!}</td>
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
