<html><head></head><body>
       <table  border='0' style='border: solid thin white' border-collapse:collapse; width='100%' cellpadding='10'>
       <tr style='background: white;'><td>  
       
                   <table border='0'  style="border:thin solid #ccc;"align='center' width='80%' cellpadding='0'>
      
           <tr>
        <td cellpadding='10' style='height:50px; text-align: center'>
        <img src="{{ asset('assets/img/logo2.jpg') }}" alt='fountain logo'> 
        </td>
        </tr>                     
                       
                       
   <tr><td cellpadding='10' style='height:50px; background:#ef4135;color:white; font-size:18;font-weight: bolder'>
       &nbsp;&nbsp;Believers' Class Online  &nbsp;&nbsp;

       </td></tr>       
        <tr >
        <tr  style='background: #fff;'><td>
 <table border='0' width='80%' cellpadding='5'>
 <tr width='100%' ><td>


 <table border='0' width='80%' cellpadding='5'>
 <tr width='100%' ><td>



<h3 style="color:#a39161">{{$classtitle}}</h3>
<strong>Full name:</strong><br />
{{$name}}<br /><br />
<strong>Email:</strong><br />
{{$email}}<br /><br />


<h3 style="color:#a39161"> Answers</h3>

<?php


$ans = $counts + 1 ;
$startNum = 1;
for($i=$startNum;$i<$ans;$i++){


echo "<strong>Answer </strong>".$i."<br />".$answers["answer".$i]."<br /><br />";

}

?>




<br />
<br /><br /> 

<br />
</td></tr></table>



</td></tr></table>

       </td> 
       </tr>
       <tr><td cellpadding='10' style='height:50px; background:#a39161;color:white; font-size:11;'>
       &nbsp;&nbsp; &copy;&nbsp;&nbsp; The Fountain of Life Church: 12, Industrial Estate Road, Ilupeju, Lagos | All Right Reserved  &nbsp;&nbsp;
  <a  style="color:#665835;text-decoration:none;" href="{{ asset('http://believersclass.tfolc.org/')}}">Believers Online Classes </a> 


       
       
       </td></tr>
        
       
       
       
    
       
       
       
       
       
       
       
       
	</table>
        </td></tr></table>
         </body></html>