<?php
if(HYDROGEN !== TRUE){
	die("OH: Access Denied");
}
?>
<!-- Panel -->
<div id="toppanel">
	<div id="panel">
		<div class="content clearfix">
			<div class="left">
				<h1>The Sliding jQuery Panel</h1>
				<h2>A register/login solution</h2>		
				<p class="grey">You are free to use this login and registration system in you sites!</p>
				<h2>A Big Thanks</h2>
				<p class="grey">This tutorial was built on top of <a href="http://web-kreation.com/index.php/tutorials/nice-clean-sliding-login-panel-built-with-jquery" title="Go to site">Web-Kreation</a>'s amazing sliding panel.</p>
			</div>

            <?php
			if(empty($_SESSION['LoggedIn'])){
			?>
            
			<div class="left">
				<!-- Login Form -->
				<form class="clearfix" action="./user.php?action=auth" method="POST">
					<h1>Member Login</h1>
                    <?php
						if(isset($_SESSION['msg']['login-err']))
						{
							echo '<div class="err">'.$_SESSION['msg']['login-err'].'</div>';
							unset($_SESSION['msg']['login-err']);
						}
					?>
					<label class="grey" for="username">Username:</label>
					<input class="field" type="text" name="Login_Username" id="username" value="" size="20" />
					<label class="grey" for="password">Password:</label>
					<input class="field" type="password" name="Login_Passwd" id="password" size="25" />
	            	<label><input name="Login_RememberMe" id="rememberMe" type="checkbox" checked="checked" value="1" /> &nbsp;Remember me</label>
        			<div class="clear"></div>
					<input type="submit" name="submit" value="Login" class="bt_login" />
				</form>
			</div>
            
            <?php
			}else{
			?>
            
            <div class="left right">
				<?php
				if(isset($_SESSION['msg']['login-err']))
						{
							echo '<div class="err">'.$_SESSION['msg']['login-err'].'</div>';
							unset($_SESSION['msg']['login-err']);
						}
				?>
			</div>
			
            <div class="left">
				<h1>Members panel</h1>
				<p></p>
				<a href="./blog.php">My Blogs</a><br />
				<a href="./user.php">Account Settings</a><br />
				<a href="./user.php?action=logout">Log off</a><br />
            </div>
			
            <?php
			}
			?>
		</div>
	</div> <!-- /login -->	

    <!-- The tab on top -->	
	<div class="tab">
		<ul class="login">
	    	<li class="left">&nbsp;</li>
	        <li>Hello <?php echo $_SESSION['Username']; ?>!</li>
			<li class="sep">|</li>
			<li id="toggle">
				<a id="open" class="open" href="#"><?php echo $_SESSION['UserID'] ? 'Open Panel' : 'Log In | Register';?></a>
				<a id="close" style="display: none;" class="close" href="#">Close Panel</a>			
			</li>
	    	<li class="right">&nbsp;</li>
		</ul> 
	</div> <!-- / top -->
	
</div> <!--panel -->