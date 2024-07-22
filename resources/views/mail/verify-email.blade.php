@component('mail::message')
# Verify Email Address

Hi @if(isset($name)){{$name}}@endif, <br>Please click the button below to verify your email address.


<a href="{{ route('email.verified', ['url' => $url]) }}">Verify Email</a>
{{--
@component('mail::button', ['url' => $url])
Verify Email
@endcomponent
--}}

If you did not create an account, no further action is required.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
