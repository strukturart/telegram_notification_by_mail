<?php

///////////////////////////
////C O N F I G///////////
$tgm_bot_pw = "";
$tgm_usr = "";
$mail_host = "";
$mail_usr = "";
$mail_from = "";
$mail_from_name = "";
$mail_to = "";
$mail_pw = "";

//////////////////////////
//////////////////////////

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';


define ('url',"https://api.telegram.org/bot".tgm_bot_pw."/");
$update = json_decode(file_get_contents('php://input') ,true);




$chat_id = $update['message']['chat']['id'];
$chat_name = $update['message']['chat']['title'];
$firstname = $update['message']['from']['first_name'];
$lastname = $update['message']['from']['last_name'];
$text = $update['message']['text'];



//test if it works
//file_get_contents(url."sendmessage?text=".$text."&chat_id=".$chat_id);


$message = $text;
$mail_subject = "Telegram: ".$chat_name;


//no notification of yourself
if($name != $tgm_usr)
{



	$mail = new PHPMailer;
	
	$mail->isSMTP();                                      // Set mailer to use SMTP
	$mail->Host = $mail_host;  					// Specify main and backup SMTP servers
	$mail->SMTPAuth = true;   
	$mail->SMTPDebug = 0;                            // Enable SMTP authentication
	$mail->Username = $mail_usr;                 // SMTP username
	$mail->Password = $mail_pw;                           // SMTP password
	$mail->SMTPSecure = 'tls';  
	$mail->Port = 587;                          // Enable encryption, 'ssl' also accepted
	

	$mail->From = $mail_from;
	$mail->FromName = $mail_from_name;
	$mail->addAddress($mail_to);     // Add a recipient        
	$mail->addReplyTo($mail_from);
	//$mail->addBCC('');
	//$mail->AddCC('');
	$mail->WordWrap = 150;                                 
	$mail->isHTML(true);                               
	$mail->CharSet = 'utf-8';
	$mail->Subject = $mail_subject;
	$mail->Body    = '<html>
		<head>
		<title>Telegram notification</title>
		<style>
      	div {margin-buttom:10px;}
      	img {width:100px;}
    	</style>
		
		</head>
 
		<body style="font-size:12px; font-family="arial"; line-height:16px">
		<div>'.$firstname.' '.$lastname.'</div>
		<div>'.$message.'</div>
		</body>
		</html>';
		
		
	$mail->AltBody = '';

	if(!$mail->send()) {
	 
		echo '0';
	   
	} 
	else {
		echo '1';





		
	
	}	

}		

		
	

     checkJSON($chatID,$update);

	function checkJSON($chatID,$update){
	
		$myFile = "log.txt";
		$updateArray = print_r($update,TRUE);
		$fh = fopen($myFile, 'a') or die("can't open file");
		fwrite($fh, $chatID ."\n\n");
		fwrite($fh, $updateArray."\n\n");
		fclose($fh);
	}

?>


