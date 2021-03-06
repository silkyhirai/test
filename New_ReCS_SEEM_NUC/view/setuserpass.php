<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width,user-scalable=no,maximum-scale=1" />
		<!-- ※デフォルトのスタイル（style.css） -->
		<link rel="stylesheet" media="all" type="text/css" href="../assets/css/style.css" />
		<!-- ※タブレット用のスタイル（tablet.css） -->
		<link rel="stylesheet" media="all" type="text/css" href="../assets/css/tablet.css" />
		<!-- ※スマートフォン用のスタイル（smart.css） -->
		<link rel="stylesheet" media="all" type="text/css" href="../assets/css/smart.css" />

		<!-- BootStrapの設定 -->
		<link rel="stylesheet" href="../lib/bootstrap-3.3.7-dist/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

        <!-- Optional theme -->
        <link rel="stylesheet" href="../lib/bootstrap-3.3.7-dist/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
        <!-- Latest compiled and minified JavaScript -->
        <script src="../lib/bootstrap-3.3.7-dist/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	</head>
<?php
	require_once("../core/client.php");
	require_once("../core/users.php");
	require_once("../core/ticket.php");
	require_once("authorize.php");

	InitializeClient();

	$db=ConnectSQL();
	$ticket=GetClientValue("ticket");
	if(!VerifyTicket($db,$ticket,"edit_account")){
		print("ERROR: not allowed operation");
		die();
	}

	$userid=GetUserId($db,$ticket);
	$username=GetUserName($db,$userid);
	$curpass=$_POST["userpassword"];
	$pass0=$_POST["usernewpass0"];
	$pass1=$_PSOT["usernewpass1"];

	if(!Authorize($db,$userid,$username,$curpass)){
		print("ERROR: authorize error");
		die();
	}
	if(strcp($pass0,$pass1)!=0){
		print("ERROR: wrong password");
		die();
	}
	if(strcmp()==0){
		print("ERROR: empty password");
		die();
	}

	UpdatePassWord($db,$userid,$username,$curpass,$pass0);

	print("
		<center>
			password update:
			<table>
				<tr>
					<td>user id:</td>
					<td>$userid</td>
				</tr>
				<tr>
					<td>username:</td>
					<td>".htmlspecialchars($username)."</td>
				</tr>
			</table>
		</center>
	");
	print("<br><a href='../index.php'>戻る</a>");
?>
</heml>
