@component('mail::message')

{{-- Logo --}}
<div style="text-align: center;">
    <img src="{{ asset('assets/images/DLSAU.png') }}" width="100" alt="DLSAU Logo">
</div>

# Password Reset Request

Hello,  

We received a request to reset your password. Click the button below to create a new password:

@component('mail::button', ['url' => $actionUrl, 'color' => 'success'])
Reset Password
@endcomponent

If you didn’t request a password reset, please ignore this email.

Thanks,  
**OSFR Team**  

{{-- Footer --}}
@slot('subcopy')
If you’re having trouble clicking the "Reset Password" button, copy and paste the following URL into your browser:  
[{{ $actionUrl }}]({{ $actionUrl }})
@endslot

@endcomponent
