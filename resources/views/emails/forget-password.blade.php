@component('mail::message')
Click the button below to set new password

@component('mail::button', ['url' => 'http://believersclass.tfolc.org/reset/'.$token])
 set password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
