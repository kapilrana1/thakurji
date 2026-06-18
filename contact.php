<?php
header("Content-type: text/html; charset=utf-8");
//**********************************************
if(empty($_POST['js'])){

$log =="";
$error="no"; 

		$posName = addslashes($_POST['posName']);
		$posName = htmlspecialchars($posName);
		$posName = stripslashes($posName);
		$posName = trim($posName);
		
		$posEmail = addslashes($_POST['posEmail']);
		$posEmail = htmlspecialchars($posEmail);
		$posEmail = stripslashes($posEmail);
		$posEmail = trim($posEmail);

		$posText = addslashes($_POST['posText']);
		$posText = htmlspecialchars($posText);
		$posText = stripslashes($posText);
		$posText = trim($posText);
 
if(!$posName || strlen($posName)>20 || strlen($posName)<3) {
$log.="<li>Not right Name(3-15)!</li>"; $error="yes"; }

function isEmail($posEmail)
            {
                return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i"
                        ,$posEmail));
            } 
			
if($posEmail == '')
                {
	$log .= "<li>Enter your email!</li>";
	$error = "yes";
                  
                }			

else if(!isEmail($posEmail))
                {
                   
	$log .= "<li>Incorrect e-mail!</li>";
	$error = "yes";
                }

if (empty($posText))
{
	$log .= "<li>No message text!</li>";
	$error = "yes";
}

if(strlen($posText)>1010)
{
	$log .= "<li>To long text!</li>";
	$error = "yes";
}

$mas = preg_split("/[\s]+/",$posText);
foreach($mas as $index => $val)
{
  if (strlen($val)>60)
  {
	$log .= "<li>To long  words in the text!</li>";
	$error = "yes";
	break;
  }
}
sleep(2);

if($error=="no")
{

$to = "thakurjiass.itgst2k20@gmail.com";//Your Email here
$mes = "Name - $posName \n\n Message - $posText \n\n";

$from = $posEmail;
$sub = '=?utf-8?B?'.base64_encode('Message').'?=';
$headers = 'From: '.$from.'
';
$headers .= 'MIME-Version: 1.0
';
$headers .= 'Content-type: text/plain; charset=utf-8
';
mail($to, $sub, $mes, $headers);
echo "1"; 
}
else
{ 
		echo "<p style='padding-left:10px; padding-top:15px;'><font color=#fff><strong>Error!</strong></font></p><ul style='list-style: none; font: 13px Arial; color:#fff; box-shadow: 0px 2px 0px #6c6c75; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px; background-color: #4c4c56; padding:5px;'>".$log."</ul><br />"; //Нельзя отправлять пустые сообщения

}
}