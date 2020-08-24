
@component('mail::message')

Thanks for signing up with Believers Class.<br /><br />
Your username is ( {{ $email }} ) <br /><br />

@component('mail::button', ['url' => 'http://believersclass.tfolc.org/', 'color'=>'danger'])
Login
@endcomponent

Thanks,<br>
info@believersclass.tfolc.org<br />
+234-7098505186/7<br /><br /> 
{{ config('app.name') }}
@endcomponent
