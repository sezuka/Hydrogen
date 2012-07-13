<?php
DEFINE("HYDROGEN", TRUE);
include_once("include/db.php");
session_start();

switch($_GET['action']){
		case "new":
			if($_SESSION['LoggedIn'] != 1){
				header("location:".$_SERVER['PHP_SELF']."?action=login");
				break;
			}
			if(!empty($_POST['newPost_title']) && !empty($_POST['newPost_content'])){
				mysql_query("INSERT INTO post (timestamp, type, title, content) VALUES('".time()."', '1', '".$_POST['newPost_title']."', '".$_POST['newPost_content']."');") or die(mysql_error());
				++$_SESSION['PostCount'];
				mysql_query("UPDATE user SET postcount='".$_SESSION['PostCount']."' WHERE id='".$_SESSION['UserID']."';") or die(mysql_error());
				header("location:./");
				break;
			}elseif(empty($_POST['newPost_title'])){
				echo "Post title is empty!";
			}elseif(empty($_POST['newPost_content'])){
				echo "Post content is empty!";
			}
			echo "<!DOCTYPE HTML>
						<html>
							<head>
								<title>Sezuka's Stuff: New Post</title>
								<meta name=\"description\" content=\"A blog project\" />
								<meta name=\"author\" content=\"Sezuka\" />
								<meta charset=\"UTF-8\" />
								<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\" />
						</head>
						<body>
							<div class=\"NewPost\">
								<form method=\"POST\" name=\"newPost\" action=\"post.php?action=new\">
									<fieldset>
										<legend>New Post</legend>
										<input type=\"text\" name=\"newPost_title\" size=\"50\" /><br />
										<textarea cols=\"50\" rows=\"5\" name=\"newPost_content\"></textarea><br />
										<input type=\"submit\" value=\"Post that shit!\" />
									</fieldset>
							</form>
							</div>
						</body>
					</html>";
			break;

		case "hide":
			if($_SESSION['LoggedIn'] != 1){
				header("location:".$_SERVER['PHP_SELF']."?action=login");
				break;
			}
			if(!empty($_REQUEST['ID'])){
				mysql_query("UPDATE post SET hidden='1' WHERE id='".$_REQUEST['ID']."';") or die(mysql_error());
				--$_SESSION['PostCount'];
				mysql_query("UPDATE user SET postcount='".$_SESSION['PostCount']."' WHERE id='".$_SESSION['UserID']."';") or die(mysql_error());
			}
			header("location:./");
			break;
		
		case "show":
			if($_SESSION['LoggedIn'] != 1){
				header("location:".$_SERVER['PHP_SELF']."?action=login");
				break;
			}
			if(!empty($_REQUEST['ID'])){
				mysql_query("UPDATE post SET hidden='0' WHERE id='".$_REQUEST['ID']."';") or die(mysql_error());
				++$_SESSION['PostCount'];
				mysql_query("UPDATE user SET postcount='".$_SESSION['PostCount']."' WHERE id='".$_SESSION['UserID']."';") or die(mysql_error());
			}
			header("location:./");
			break;
		
		case "remove":
			if($_SESSION['LoggedIn'] != 1){
				header("location:".$_SERVER['PHP_SELF']."?action=login");
				break;
			}
			if(!empty($_REQUEST['ID'])){
				mysql_query("DELETE FROM post WHERE id='".$_REQUEST['ID']."';") or die(mysql_error());
				--$_SESSION['PostCount'];
				mysql_query("UPDATE user SET postcount='".$_SESSION['PostCount']."' WHERE id='".$_SESSION['UserID']."';") or die(mysql_error());
			}
			header("location:./");
			break;
			
		case "login":
			if($_SESSION['LoggedIn'] == 1){
				header("location:./");
				break;
			}
			/* Database authentication */
			if(!empty($_REQUEST['Login_Username']) && !empty($_REQUEST['Login_Passwd'])){
				$user = mysql_query("SELECT * FROM user WHERE username='".$_REQUEST['Login_Username']."' AND password='".md5($_REQUEST['Login_Passwd'])."';");
				if(mysql_num_rows($user) > 0){
					while($row = mysql_fetch_assoc($user)){
						$_SESSION['LoggedIn'] = 1;
						$_SESSION['UserID'] = $row['id'];
						$_SESSION['Username'] = $row['username'];
						$_SESSION['PostCount'] = $row['postcount'];
						header("location:./");
						break 2;
					}
				}else{
					echo "Incorrect Username or Password! :/";
				}
			}
			
			echo "<!DOCTYPE HTML>
						<html>
							<head>
								<title>Sezuka's Stuff: Login</title>
								<meta name=\"description\" content=\"A blog project\" />
								<meta name=\"author\" content=\"Sezuka\" />
								<meta charset=\"UTF-8\" />
								<link rel=\"stylesheet\" type=\"text/css\" href=\"css/style.css\" />
						</head>
						<body>
							<div class=\"Login\">
								<form method=\"POST\" name=\"Login\" action=\"post.php?action=login\">
									<fieldset>
										<legend>Login</legend>
										Username: <input type=\"text\" name=\"Login_Username\" size=\"20\" /><br />
										Password: <input type=\"password\" name=\"Login_Passwd\" /><br />
										<input type=\"submit\" value=\"For the love of God! Let me in! D:\" />
									</fieldset>
							</form>
							</div>
						</body>
					</html>";
			break;
		
		case "logout":
			session_destroy();
			header("location:./");
			break;
		
		default:
			header("location:./");
			break;
}
?>
