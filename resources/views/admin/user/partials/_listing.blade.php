<table class='table table-hover text-center my-1' id="aims360_products" style="border-color: black;width:100% !important;">
    <thead>
    <tr class="text-black">
        <td><strong>{!! __('First Name') !!}</strong></td>
        <td><strong>{!! __('Last Name') !!}</strong></td>
        <td><strong>{!! __('Email') !!}</strong></td>
        <td><strong>{!! __('Role') !!}</strong></td>
        <td><strong>{!! __('Status') !!}</strong></td>
        <td><strong>{!! __('Action') !!}</strong></td>
    </tr>
    </thead>
    <tbody>
    @if($users->count() > 0)
        @foreach($users as $key => $user)
            <tr>
                <td>{!! __($user->first_name) !!}</td>
                <td>{!! __($user->last_name) !!}</td>
                <td>{!! __($user->email) !!}</td>
                <td>{!! __(App\Helpers\GeneralHelper::GET_ROLE($user)) !!}</td>
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
                <td><a href="{{route('admin.user.edit',[$user->id])}}" style="color: mediumpurple;"><i class="fa fa-edit"></i></a></td>
            </tr>
        @endforeach
    @else
        <tr><td colspan="10">{!! __('No Users Found.') !!}</td></tr>
    @endif
    </tbody>
</table>
<div class="page-link" style="float:left">
    {!! $users->links('pagination::bootstrap-4') !!}
</div>
