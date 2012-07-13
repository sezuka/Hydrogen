<?php
DEFINE("HYDROGEN", TRUE, true);
require("include/function.php");
session_start();

if(empty($_SESSION)){
	$_SESSION['UserID'] = 0;
	$_SESSION['Username'] = "Guest";
}

$blog = !empty($_GET['id']) ? new Blog(mysql_real_escape_string($_GET['id'])) : new Blog(0);
$script = '';
if(!empty($_SESSION['msg'])){
	// The script below shows the sliding panel on page load
	$script = '
	<script type="text/javascript">
		$(function(){
			$("div#panel").show();
			$("#toggle a").toggle();
		});
	</script>';
}

?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title><?php echo $blog->getBlogTitle(); ?></title>
		<link rel="stylesheet" type="text/css" href="css/style.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="css/slide.css" media="screen" />
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>

		<!-- PNG FIX for IE6 -->
		<!-- http://24ways.org/2007/supersleight-transparent-png-in-ie6 -->
		<!--[if lte IE 6]>
			<script type="text/javascript" src="login_panel/js/pngfix/supersleight-min.js"></script>
		<![endif]-->

		<script src="js/slide.js" type="text/javascript"></script>
<?php echo $script; ?>
	</head>
	<body>
		<?php include("include/overhead.php"); ?>
		<div class="pageContent">
			<div id="main">
				<div class="container">
					<h1><?php echo $blog->getBlogTitle(); ?></h1>
					<h2><?php echo $blog->getBlogSubtitle(); ?></h2>
				</div>

				<?php
				$blog->getPosts(); 
				?>
		
				<div class="container copyright">
					<strong>Hydrogen</strong> by Sezuka. Copyright &copy; <?php echo date("Y"); ?>
				</div>
			</div>
		</div>
	</body>
</html>