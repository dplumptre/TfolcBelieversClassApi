<tr>
<td class="header">
<a href="http://believersclass.tfolc.org" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
<img src="{{asset('images/logo.png')}}" class="logo" alt="Believer's Logo">
@else
{{ $slot }}
@endif
</a>
</td>
</tr>
