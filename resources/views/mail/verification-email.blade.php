<div style="background-color: rebeccapurple; color: white; padding: 20px;">
    <strong>Email Verification</strong>
    <div>Hello <strong>{{ $name }}</strong></div>
    <br><br>
    <div><a class="text-white" href="{{url('verify/email/'.$token)}}">Click here to verify email</a></div>
</div>
