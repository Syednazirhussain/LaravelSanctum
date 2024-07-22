@component('mail::message')
# Verify Email Address

Hi @if(isset($name)){{$name}}@endif, <br>Please click the button below to verify your email address.

@component('mail::button', ['url' => $url])
Verify Email
@endcomponent

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
