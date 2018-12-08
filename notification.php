<?php
require 'config.php';

if (!isset($_GET['secret']) || $_GET['secret'] !== $file_pw) {
    die("I'm safe =)");
}



//////////////////////////
//////////////////////////
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

define ('url',"https://api.telegram.org/bot".$tgm_bot_token."/");

$update = json_decode(file_get_contents('php://input'),true);

////////
$update_id = $update['update_id'];
$chat_id = $update['message']['chat']['id'];
$chat_name = $update['message']['chat']['title'];
$firstname = $update['message']['from']['first_name'];
$lastname = $update['message']['from']['last_name'];
$message = $update['message']['text'];
$bot = $update['message']['from']['is_bot'];
$photo_id = $update['message']['photo']['0']['file_id'];
$date_sent = $update['message']['date'];

/////////////////////
///////chat whitelist
$chat = false;
if (in_array($chat_id, $chat_group)) {
    $chat = true;
}
$chat = true;

///////////////////
/////image attachment
/////be careful because your bot token is in the img url !!!!
//////////////////

$image_path = "";
if($photo_id != "")
{
	$image_path_result = json_decode(file_get_contents('https://api.telegram.org/bot'.$tgm_bot_token.'/getFile?file_id='.$photo_id),true);

	$image_path = $image_path_result['result']['file_path'];
	$image_path = "https://api.telegram.org/file/bot".$tgm_bot_token."/".$image_path;
}



if($chat_name == "")
{
	$mail_subject = "(TG) ".$firstname.' '.$lastname;
}
else
{
	$mail_subject = $chat_name.': '.$firstname.' '.$lastname;
}








if
(
	$firstname != $tgm_usr and ////do not send your own message
	$chat == true ////chat whitelist
)

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
	//$mail->addReplyTo($mail_from);
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
		body
		{
			font-size:12px;
		}
      	div 
      	{
      		margin-buttom:10px;
      	}
      	img 
      	{
      		width:200px;
      		height:auto;
      	}
      	div.text
      	{
      		padding:20px 0 10px 0;
      	}
      	div.dateTime
      	{
      		font-size:10px;
      	}
      	footer
      	{
      		border-top:1px dashed black;
      		border-bottom:1px dashed black;
      		width:140px;
      	}
    	</style>
		
		</head>
 
		<body>
			<div><strong>'.$firstname.' '.$lastname.'</strong></div>
			<br>
			<div class="dateTime">'.date("d.m.Y, H:i",$date_sent).'</div>
			<div id="text">'.$message.'</div>
			<br>
			<img src='.$image_path.'>
			<br>
			<footer>Telegram notification by email.</footer>
			

			
		</body>
		</html>';
		
		
	$mail->AltBody = '';

	if(!$mail->send()) 
	{
	 

		exit;
	   
	} 
	else 
	{

		function checkJSON($chatID,$update)
		{
			$myFile = "log.txt";
			$updateArray = print_r($update,TRUE);
			$fh = fopen($myFile, 'a') or die("can't open file");
			fwrite($fh, $chatID ."\n\n");
			fwrite($fh, $updateArray."\n\n");
			fclose($fh);
		}

			 checkJSON($chatID,$update);

	exit;

	}	



}	

else
{


	function checkJSON($chatID,$update)
	{
	
		$myFile = "error_log.txt";
		$updateArray = print_r($update,TRUE);
		$fh = fopen($myFile, 'a') or die("can't open file");
		fwrite($fh, $chatID ."\n\n");
		fwrite($fh, $updateArray."\n\n");
		fclose($fh);
	}

		checkJSON($chatID,$update);

}	

		
exit;
    
?>


