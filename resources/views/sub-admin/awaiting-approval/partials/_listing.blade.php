<table class='table table-hover text-center my-1' id="aims360_products" style="border-color: black;width:100% !important;">
    <thead>
    <tr class="text-black">
        <td><strong>{!! __('Username') !!}</strong></td>
        <td><strong>{!! __('Email') !!}</strong></td>
        <td><strong>{!! __('Phone Number') !!}</strong></td>
        <td><strong>{!! __('Verify') !!}</strong></td>
        <td><strong>{!! __('Status') !!}</strong></td>
        <td><strong>{!! __('Action') !!}</strong></td>
    </tr>
    </thead>
    <tbody>
    @if($users->count() > 0)
        @foreach($users as $key => $user)
            <tr>
                <td>{!! __($user->username) !!}</td>
                <td>{!! __($user->email) !!}</td>
                <td>{!! __($user->phone_number) !!}</td>
                <td>
                    <span class="badge {!! __($user->verify === \App\Helpers\IUserStatus::VERIFIED ? 'badge-success' : 'badge-danger') !!}" id="badge">
                        {!! __(sprintf("%s", $user->verify === \App\Helpers\IUserStatus::VERIFIED ? 'Verified' : 'Not Verified')) !!}
                    </span>
                </td>
                <td>
                    <span class="badge {!! __($user->status === \App\Helpers\IUserStatus::ACTIVE ? 'badge-success' : 'badge-danger') !!}" id="badge">
                        {!! __(sprintf("%s", $user->status === \App\Helpers\IUserStatus::ACTIVE ? 'Active' : 'In-Active')) !!}
                    </span>
                </td>
                <td>
                    <div onclick="activate({{$user->id}})">
                        <i class="fa fa-user-check" style="color: rebeccapurple;cursor: pointer;"></i>
                    </div>
                </td>
            </tr>
        @endforeach
    @else
        <tr><td colspan="10">{!! __('No Users Found.') !!}</td></tr>
    @endif
    </tbody>

    @if(\App\Helpers\GeneralHelper::IS_SUB_ADMIN())
        @include('sub-admin.awaiting-approval.partials.activate-user-modal')
    @endif
</table>
<div class="page-link" style="float:left">
    {!! $users->links('pagination::bootstrap-4') !!}
</div>
<script>
    function activate(id)
    {
        $('#userId').val(id);
        $('#activateUser').modal('toggle');
    }
</script>
