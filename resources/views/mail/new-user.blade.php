@component('mail::message')

Hi {{$user->name}},

<p>You has been registered as a {{ $role->name }} user, and your account credentials are given below.</p>
<p>Email: {{ $user->email }} <br> Password: {{ $password }} </p>

<p>You can login to your account by clicking the below button.</p>

@component('mail::button', ['url' => route('login') ])
Login
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent