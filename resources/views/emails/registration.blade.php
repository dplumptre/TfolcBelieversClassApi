
@component('mail::message')

Welcome!<br /><br />

You are almost done with your registration.<br /><br />

Click the button below to activate your account 

@component('mail::button', ['url' => 'http://believersclass.tfolc.org/activate-account/'.$token])
 Activate Account
@endcomponent

Your username is ( {{ $email }} ) <br /><br />

Thanks,<br>
info@believersclass.tfolc.org<br />
+234-7098505186/7<br /><br /> 
{{ config('app.name') }}
@endcomponent
