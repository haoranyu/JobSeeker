<?php
include('db.php');
$select = mysql_query("SELECT DISTINCT `tid` FROM `twitter_record` WHERE 1");
while ($row = mysql_fetch_array($select)) {
	$find = mysql_query("SELECT * FROM `tweets` WHERE `tid` = '".$row['tid']."'");
	if(mysql_num_rows($find) == 0){
		mysql_query("DELETE FROM `twitter_record` WHERE `tid` = '".$row['tid']."'");
	}
}
?>