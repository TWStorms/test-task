<table class='table table-hover text-center my-1' id="aims360_products" style="border-color: black;width:100% !important;">
    <thead>
    <tr class="text-black">
        <td><strong>{!! __('Username') !!}</strong></td>
        <td><strong>{!! __('Email') !!}</strong></td>
        <td><strong>{!! __('Phone Number') !!}</strong></td>
        <td><strong>{!! __('Level Completed') !!}</strong></td>
        <td><strong>{!! __('Status') !!}</strong></td>
    </tr>
    </thead>
    <tbody>
    @if($users->count() > 0)
        @foreach($users as $key => $user)
            <tr>
                <td>{!! __($user->username) !!}</td>
                <td>{!! __($user->email) !!}</td>
                <td>{!! __($user->phone_number) !!}</td>
                <td>{!! __($user->level_completed) !!}</td>
                <td>
                    @if($user->verify === \App\Helpers\IUserStatus::VERIFIED)
                        <span class="badge badge-success">verified</span>
                    @endif
                    @if($user->verify === \App\Helpers\IUserStatus::NOT_VERIFIED)
                        <span class="badge badge-danger">un-verified</span>
                    @endif
                    @if($user->status === \App\Helpers\IUserStatus::ACTIVE)
                        <span class="badge badge-success">active</span>
                    @endif
                    @if($user->status === \App\Helpers\IUserStatus::IN_ACTIVE)
                        <span class="badge badge-danger">in-active</span>
                    @endif
                </td>
            </tr>
        @endforeach
    @else
        <tr><td colspan="10">{!! __('No Children Found.') !!}</td></tr>
    @endif
    </tbody>
</table>
<div class="page-link" style="float:left">
    {!! $users->links('pagination::bootstrap-4') !!}
</div>
