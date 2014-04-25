<?php
if(!isset($_COOKIE['user'])){
	$user = rand_str();
	setcookie("user", $user, time()+3600*24*365);
	$query = "INSERT INTO `twitter_accuracy`(`user`, `hit`, `sum`) VALUES ('".$user."', '0', '0')";
	mysql_query($query);
	$acc = 0;
	$num = 0;
}
else{
	$user = htmlspecialchars($_COOKIE['user']);
	$acc = get_acc($user)*100;
	$num = get_num($user);
}
if(!isset($_COOKIE['remain'])){
	$remain = num_remain_task();
	setcookie("remain", $remain, time()+3600*24*365);
}
else{
	$remain = htmlspecialchars($_COOKIE['remain']);
}
?>