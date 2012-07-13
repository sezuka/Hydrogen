<?php
DEFINE("HYDROGEN", TRUE);
require("include/db.php");
session_start();

if(empty($_SESSION['LoggedIn'])){
	$_SESSION['LoggedIn'] = 0;
}

if(empty($_GET['page'])){
	$_GET['page'] = 0;
}
//print_r($_SESSION); //Debug output
?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Sezuka's Stuff</title>
		<meta name="description" content="A blog project" />
		<meta name="author" content="Sezuka" />
		<meta charset="UTF-8" />
		<link rel="stylesheet" type="text/css" href="css/style.css" />
	</head>
	<body>
	<div id="link">
		<a href="https://twitter.com/emupoo08" class="twitter-follow-button" data-show-count="false">Follow @emupoo08</a>
		<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
		<br />
		<?php
		if($_SESSION['LoggedIn'] == 1){
			echo "<a href=\"./post.php?action=logout\" title=\"Logout\">Logout</a>";
		}
		?>
	</div>
	<a title="New Post" href="./post.php?action=new" />
		<h1>Sezuka's Stuff</h1>
	</a>
<?php
// View hidden posts (admin feature)
if($_SESSION['LoggedIn'] == 1){
	$sql_get_posts = "SELECT * FROM `post` WHERE id BETWEEN ".($_GET['page']*25)." AND ".(($_GET['page']+1)*25)." ORDER BY `id` DESC LIMIT 25";
}else{
	$sql_get_posts = "SELECT * FROM `post` WHERE hidden='0' AND id BETWEEN ".($_GET['page']*25)." AND ".(($_GET['page']+1)*25)." ORDER BY `id` DESC LIMIT 25";
}
// View hidden posts end

$posts = mysql_query($sql_get_posts); // MySQL query -- get posts

if(mysql_num_rows($posts) == 0){
	echo "<center><div class=\"Post\">There are no posts! :(</div></center>";
}else{
	while($row = mysql_fetch_assoc($posts)){ // Generate Data output -- HTML
		echo "\t\t\t<div class=\"Post\">";
		/*  Admin menu */
		if($_SESSION['LoggedIn'] == 1){
			if($row['hidden'] == 1){
				echo "\t\t<a style=\"text-align: right;\" href=\"post.php?action=show&ID=".$row['id']."\">Unhide</a>";
			}else{
				echo "\t\t<a style=\"text-align: right;\" href=\"post.php?action=hide&ID=".$row['id']."\">Hide</a>";
			}
			echo " | ";
			echo "<a onClick=\"return confirm('Are you sure you wish to remove this post?');\" style=\"text-align: right;\" href=\"post.php?action=remove&ID=".$row['id']."\">Remove</a>";
		}
		/* Admin menu end */
		echo "\t\t<fieldset>\n";
		if($row['hidden'] == 1){
			echo "\t\t\t<legend title=\"#".$row['id']." posted on ".date("H:i d/m/y", $row['timestamp'])."\">(HIDDEN) ".$row['title']."</legend>\n";
		}else{
			echo "\t\t\t<legend title=\"#".$row['id']." posted on ".date("H:i d/m/y", $row['timestamp'])."\">".$row['title']."</legend>\n";
		}
		echo "\t\t\t<p>".$row['content']."</p>\n";
		echo "\t\t</fieldset><br />\n";
		echo "\t\t\t</div>";
	} // Generate Data output end
}	
?>
	</body>
</html>