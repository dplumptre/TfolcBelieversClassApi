

@component('mail::message')

<strong>Full name:</strong><br />
{{$name}}<br /><br />
<strong>Email:</strong><br />
{{$email}}<br /><br />


<h2 style="color:#a39161"> Answers</h2>

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
