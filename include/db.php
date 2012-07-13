<?php
if(HYDROGEN !== TRUE){
	die("DB: Access Denied");
}
mysql_connect("localhost", "root", "toor") or die(mysql_error());
mysql_select_db("fuck.it") or die(mysql_error());

?>