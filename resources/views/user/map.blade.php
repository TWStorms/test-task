@extends('layouts.app')
@section('title', 'Mind Map')
@section('content')
    <div class="container-fluid" style="{{Auth::user()->status != \App\Helpers\IUserStatus::ACTIVE ? 'filter: blur(20px)' : ''}};">
        <div id="maps">
            <div id="{{\App\Helpers\IMMPConfig::MMP_ID}}" class="mmp"></div>
        </div>
    </div>
@endsection
@section('page-js')
<script src="{{ asset('assets/js/d3/dist/d3.js') }}"></script>
<script src="{{ asset('assets/js/mmp/build/mmp.min.js') }}"></script>
<script>
    let myMap = mmp.create("{{ \App\Helpers\IMMPConfig::MMP_ID }}", {
        rootNode: {
            name: "{{ $username }}"
        }
    }), nodes = @php echo $nodes @endphp;
    nodes = nodes.nodes
    nodes.forEach(v => myMap.addNode({name : v.label, colors :{name : 'white',background: '#800080'}}, v.parent_id) )

    myMap.on('nodeSelect', async function (e) {
        let array = e.id.split('_');
        let id = JSON.parse(array[array.length - 1]);
        let name = e.name;
        if (id !== 0) {
            window.location.href = `/user/map/${name}`;
        }
    })
</script>
@endsection
