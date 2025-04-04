@component('mail::message')

# Password Reset Request

Hello,  

We received a request to reset your password. Click the button below to create a new password:

@component('mail::button', ['url' => $actionUrl, 'color' => 'success'])
Reset Password
@endcomponent

If you didn’t request a password reset, please ignore this email.

Thanks,  
**OSFR Team**  


@endcomponent
