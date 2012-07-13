<?php
DEFINE("HYDROGEN", TRUE);
include_once("include/db.php");
session_start();

switch($_GET['action']){
		case "new":
			$error = array();
			
			if(!empty($_POST['newPost_title']) && !empty($_POST['newPost_content']) && !empty($_REQUEST['blogid'])){
				mysql_query("INSERT INTO post (blog, timestamp, type, title, content) VALUES ('{$_REQUEST['blogid']}', '".time()."', '1', '{$_POST['newPost_title']}', '{$_POST['newPost_content']}');") or die(mysql_error());
				header("location:./blog.php?id={$_REQUEST['blogid']}");
				break;
			}elseif(empty($_POST['newPost_title'])){
				$error[] = "Post title is empty!";
				//header("location:./blog.php?id={$_REQUEST['blogid']}");
				header("location:./blog.php?id=".$_REQUEST['blogid']);
			}elseif(empty($_POST['newPost_content'])){
				$error[] = "Post content is empty!";
				header("location:./blog.php?id=".$_REQUEST['blogid']);
			}elseif(empty($_REQUEST['blogid'])){
				$error[] = "Invalid blog id!";
			}
			break;

		case "hide":
			if(!empty($_REQUEST['ID'])){
				mysql_query("UPDATE post SET hidden='1' WHERE id='".$_REQUEST['ID']."';") or die(mysql_error());
			}
			break;
		
		case "show":
			if(!empty($_REQUEST['ID'])){
				mysql_query("UPDATE post SET hidden='0' WHERE id='".$_REQUEST['ID']."';") or die(mysql_error());
			}
			break;
		
		case "remove":
			if(!empty($_REQUEST['ID'])){
				mysql_query("DELETE FROM post WHERE id='".$_REQUEST['ID']."';") or die(mysql_error());
			}
			break;
		default:
			break;
}

if(!empty($error)){
	$_SESSION['msg']['login-err'] = implode('<br />', $error);
}

if(!empty($_SERVER['HTTP_REFERER'])){
	header('location:'.$_SERVER['HTTP_REFERER']);
	//$url = explode("/", $_SERVER['HTTP_REFERER']);
	//echo $url[4];
}
?>
