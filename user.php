<?php
DEFINE("HYDROGEN", TRUE);
require("include/db.php");
session_start();

if(isset($_SESSION['LoggedIn']) && !isset($_COOKIE['MyNameIsEarl']) && !$_SESSION['Login_RememberMe'])
{
	$_SESSION = array();
	session_destroy();
}

switch($_GET['action']){
	case "logout":
		$_SESSION = array();
		session_destroy();
		header("Location:./");
		exit;

	case "auth":
		$error = array();

		if(empty($_REQUEST['Login_Username']) || empty($_REQUEST['Login_Passwd'])){
			$error[] = 'Yo dawg, you forgot your name or password!';
			break;
		}
		
		if(!count($error)){
			$_REQUEST['Login_Username'] = mysql_real_escape_string($_REQUEST['Login_Username']);
			$_REQUEST['Login_Passwd'] = mysql_real_escape_string($_POST['Login_Passwd']);
			$_REQUEST['Login_RememberMe'] = (int)$_REQUEST['Login_RememberMe'];
			// New Password encryption hash		
			// $user = mysql_query("SELECT * FROM user WHERE username='{$_REQUEST['Login_Username']}' AND password='".md5($_REQUEST['Login_Username'].md5(md5($_REQUEST['Login_Username'].$_REQUEST['Login_Passwd']).).$_REQUEST['Login_Passwd']"';");
			$user = mysql_query("SELECT * FROM user WHERE username='{$_REQUEST['Login_Username']}' AND password='".md5($_REQUEST['Login_Passwd'])."';");
			if(mysql_num_rows($user) == 1){
				while($row = mysql_fetch_assoc($user)){
				$_SESSION['LoggedIn'] = 1;
				$_SESSION['UserID'] = $row['id'];
				$_SESSION['Username'] = $row['username'];
				$_SESSION['Login_RememberMe'] = $_REQUEST['Login_RememberMe'];
				setcookie('MyNameIsEarl', $_REQUEST['Login_RememberMe']);
				mysql_query("UPDATE user SET lastlogindate=".time()." WHERE id={$row['id']}") or die(mysql_error());
				header("location:./");
				}
			}else{
				$error[] ="Incorrect Username or Password!";
				break;
			}
		}
		
	default:
		header('location:./');
		exit;
}
	
if(!empty($error)){
	$_SESSION['msg']['login-err'] = implode('<br />', $error);
	header("Location:./user.php");
	exit;
}
?>