<form method="POST" class="ajaxRequest" id="complete-user-signup" action="{{ route('supervisor.blogger.update') }}"
      autocomplete="off">
    @csrf

    <div class="form-group">
        <div class="row">
            <div class="col py-2"><input type="text" class="form-control" name="first_name" placeholder="First Name" required="required" value="{{$user->first_name ?? ''}}"></div>
            <div class="col py-2"><input type="text" class="form-control" name="last_name" placeholder="Last Name" required="required" value="{{$user->last_name ?? ''}}"></div>
        </div>
    </div>
    <input type="hidden" name="id" value="{{$user->id}}">
    <div class="form-group ">
        <div class="row">
            <div class="col py-2"><input type="email" class="form-control" name="email" placeholder="Email" required="required" value="{{$user->email ?? ''}}"></div>
        </div>
    </div>
    <div class="form-group text-white">
        <div>
            <button type="submit" class="btn" style="background-color: mediumpurple; color: white;">Update</button>
        </div>
    </div>
</form>
