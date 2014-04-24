<?php
include('db.php');
include('function.php');
$tid = htmlspecialchars($_POST['tid']);
$user = htmlspecialchars($_POST['user']);

$val = get_real_val($tid);
mysql_query("INSERT INTO `twitter_record`(`tid`, `user`, `judge`) VALUES ('".$tid."', '".$user."', '0')");
if($val == -1){
	$flag = -1;
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
?>