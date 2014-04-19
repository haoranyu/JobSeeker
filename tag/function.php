<?php 
function rand_str(){
	return substr( "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ" ,mt_rand( 0 ,50 ) ,1 ) .substr( md5( time() ), 1);
}
function rand_case(){
	return time()%3 - 1;
}
function get_real_val($tid){
	$query = mysql_query("SELECT * FROM `tweets` WHERE `tid` = '".$tid."' LIMIT 1");
	$row = mysql_fetch_array($query);
	return intval($row['related']);
}
function get_num($user){
	$query = mysql_query("SELECT * FROM `twitter_accuracy` WHERE `user` = '".$user."' LIMIT 1");
	if(mysql_num_rows($query)==0){
		return 0;
	}
	$row = mysql_fetch_array($query);
	return $row['sum'];
}
function get_acc($user){
	$query = mysql_query("SELECT * FROM `twitter_accuracy` WHERE `user` = '".$user."' LIMIT 1");
	$row = mysql_fetch_array($query);
	if(mysql_num_rows($query)==0){
		return 0;
	}
	if($row['sum'] == 0){
		return 0;
	}
	return $row['hit']/$row['sum'];
}
function update_acc_positive($user){
	if(!insert_acc_positive($user)){
		mysql_query("UPDATE `twitter_accuracy` SET `sum`=`sum`+1, `hit` = `hit`+1 WHERE `user`='".$user."'");
	}
}
function update_acc_negative($user){
	if(!insert_acc_negative($user)){
		mysql_query("UPDATE `twitter_accuracy` SET `sum`=`sum`+1 WHERE `user`='".$user."'");
	}
}
function update_acc_nature($user){
	insert_acc_nature($user);
}
function insert_acc_positive($user){
	$query = mysql_query("SELECT * FROM `twitter_accuracy` WHERE `user` = '".$user."' LIMIT 1");
	if(mysql_num_rows($query)==0){
		mysql_query("INSERT INTO `twitter_accuracy`(`user`, `hit`, `sum`) VALUES ('".$user."', '1', '1')");
		return true;
	}
	return false;
}
function insert_acc_negative($user){
	$query = mysql_query("SELECT * FROM `twitter_accuracy` WHERE `user` = '".$user."' LIMIT 1");
	if(mysql_num_rows($query)==0){
		mysql_query("INSERT INTO `twitter_accuracy`(`user`, `hit`, `sum`) VALUES ('".$user."', '0', '1')");
		return true;
	}
	return false;
}
function insert_acc_nature($user){
	$query = mysql_query("SELECT * FROM `twitter_accuracy` WHERE `user` = '".$user."' LIMIT 1");
	if(mysql_num_rows($query)==0){
		mysql_query("INSERT INTO `twitter_accuracy`(`user`, `hit`, `sum`) VALUES ('".$user."', '0', '0')");
		return true;
	}
	return false;
}
function update_record($tid){
	$pos = num_record_positive($tid);
	$neg = num_record_negative($tid);
	$sum = ($pos + $neg);
	if($sum != 0){
		if($sum >= 10 && ($pos/$sum > 0.8)){
			mysql_query("UPDATE `tweets` SET `related`='1' WHERE `tid`='".$tid."'");
		}
		else if($sum >= 10 && ($neg/$sum > 0.8)){
			mysql_query("UPDATE `tweets` SET `related`='0' WHERE `tid`='".$tid."'");
		}
	}
	if($sum >= 20){
		mysql_query("UPDATE `tweets` SET `done`='1' WHERE `tid`='".$tid."'");
	}
}
function num_record_positive($tid){
	$query = mysql_query("SELECT * FROM `twitter_record` WHERE `tid` = '".$tid."' AND `judge` = 1");
	return mysql_num_rows($query);
}
function num_record_negative($tid){
	$query = mysql_query("SELECT * FROM `twitter_record` WHERE `tid` = '".$tid."' AND `judge` = 0");
	return mysql_num_rows($query);
}
?>