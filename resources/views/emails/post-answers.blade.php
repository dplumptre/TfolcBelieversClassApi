@component('mail::message')

@component('mail::header')
<h3 style="color:#a39161">{{$classTitle}}</h3>
@endcomponent


<strong>Full name:</strong><br />
{{$name}}<br /><br />
<strong>Email:</strong><br />
{{$email}}<br /><br />


<h3 style="color:#a39161"> Answers</h3>

<?php


$ans = $counts + 1;
$startNum = 1;
for($i=$startNum;$i<$ans;$i++){


echo "<strong>Answer </strong>".$i."<br />".$data["question".$i]."<br /><br />";

}

?>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
