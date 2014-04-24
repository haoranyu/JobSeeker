<?php
if(isset($_GET['lang'])){
	$lang = htmlspecialchars($_GET['lang']);
}
else{
	$lang = 'cn';
}

include("lang/".$lang.".php");
?>