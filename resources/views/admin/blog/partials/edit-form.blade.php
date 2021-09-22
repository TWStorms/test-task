<form method="POST" class="ajaxRequest" id="complete-user-signup" action="{{ route('supervisor.blog.update') }}"
      autocomplete="off">
    @csrf

    <div class="form-group">
        <div class="row">
            <div class="col py-2"><input type="text" class="form-control" name="name" placeholder="Name" required="required" value="{{$blog->name ?? ''}}"></div>
            <div class="col py-2"><input type="text" class="form-control" name="description" placeholder="Description" required="required" value="{{$blog->description ?? ''}}"></div>
        </div>
    </div>
    <input type="hidden" name="id" value="{{$blog->id}}">
    <div class="form-group text-white">
        <div>
            <button type="submit" class="btn" style="background-color: mediumpurple; color: white;">Update</button>
        </div>
    </div>
</form>
