<?php
include('db.php');
include('function.php');
if(!(isset($_POST['tid']) && isset($_COOKIE['user']))){
	exit(json_encode(false));
}
$tid = htmlspecialchars($_POST['tid']);
$user = htmlspecialchars($_COOKIE['user']);
$val = get_real_val($tid);
$go = get_go_val($tid, $user, 0);

if($go['count'] == 2){
	//do no more update the scores
	echo json_encode(false);
}
else if($go['count'] == 1){
	if($go['status'] == true){
		if(get_acc($user) > 0.85){
			mysql_query("INSERT INTO `twitter_record`(`tid`, `user`, `judge`) VALUES ('".$tid."', '".$user."', '0')");
		}
		$flag = 1;
		update_acc_positive($user);
	}
	else{
		if(get_acc($user) > 0.85){
			mysql_query("INSERT INTO `twitter_record`(`tid`, `user`, `judge`) VALUES ('".$tid."', '".$user."', '0')");
		}
		$flag = 0;
		update_acc_inverse($user);
	}
	$acc = get_acc($user);
	$num = get_num($user);
	update_record($tid);
	echo json_encode(array('flag'=>$flag, 'num'=>$num, 'acc'=>$acc*100));
}
else{
	if(get_acc($user) > 0.85){
		mysql_query("INSERT INTO `twitter_record`(`tid`, `user`, `judge`) VALUES ('".$tid."', '".$user."', '0')");
	}
	if($val == -1){
		$flag = -1;
		$_COOKIE['remain'] -= 1;
		update_acc_nature($user);
	}
	else if($val == 0){
	// true negative
		$flag = 1;
		update_acc_positive($user);
	}
	else if($val == 1){
	// false negative
		$flag = 0;
		update_acc_negative($user);
	}
	$acc = get_acc($user);
	$num = get_num($user);
	update_record($tid);
	echo json_encode(array('flag'=>$flag, 'num'=>$num, 'acc'=>$acc*100));
}
?>