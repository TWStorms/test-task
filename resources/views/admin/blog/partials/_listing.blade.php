<table class='table table-hover text-center my-1' id="aims360_products" style="border-color: black;width:100% !important;">
    <thead>
    <tr class="text-black">
        <td><strong>{!! __('Name') !!}</strong></td>
        <td><strong>{!! __('Description') !!}</strong></td>
        <td><strong>{!! __('Blogger/Supervisor Name') !!}</strong></td>
        <td><strong>{!! __('Action') !!}</strong></td>
    </tr>
    </thead>
    <tbody>
    @if($blogs)
        @foreach($blogs as $key => $blog)
            <tr>
                <td>{!! __($blog->name) !!}</td>
                <td>{!! __($blog->description) !!}</td>
                <td>{!! __($blog->user->first_name) !!} {!! __($blog->user->last_name) !!}</td>
                <td><a href="{{route('supervisor.blog.edit', [$blog->id])}}"><i class="fa fa-edit" style="color: mediumpurple"></i></a></td>
            </tr>
        @endforeach
    @else
        <tr><td colspan="10">{!! __('No Children Found.') !!}</td></tr>
    @endif
    </tbody>
</table>
