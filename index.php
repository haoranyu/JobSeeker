<?php
require_once 'twitter.class.php';
include 'db.php'; 

date_default_timezone_set('Etc/GMT-5');

function insertTweet($tid, $uid, $uname, $uloc, $ufollowers, $ulang, $content, $query, $time){
	mysql_query("INSERT INTO `tweets`(`tid`, `uid`, `uname`, `uloc`, `ufollowers`, `ulang`, `content`, `query`, `time`, `related`)	VALUES ('".$tid."', '".$uid."', '".$uname."', '".$uloc."', '".$ufollowers."', '".$ulang."', '".$content."', '".$query."', '".$time."', '-1')");
}

function searchTweet($query){
	$consumer_key="PlnHos0ix92eiHHhtAGQ"; /* your CONSUMER-KEY */
	$consumer_sec="RHdVvhp0WExVhoWBeHP522jSgcT7lWH1vZwAJR5lkWs"; /* your CONSUMER-SECRET */
	$oauth_tok="2402116034-J6mH3jdQkCR4ty1WKXiRbjh7pWLDN0t7idS8HW1";  /* your OAUTH-TOKEN */
	$oauth_sec="CS9fjhp0ZjsEdCgaKAax8IoT4IdKjdpoM1EKyIUjkNen4"; /* your OAUTH-SECRET */
	$connection = new Twitter($consumer_key, $consumer_sec, $oauth_tok, $oauth_sec);
	$twitter = $connection->search($query);
	foreach($twitter as $t){
		if(!isset($t->retweeted_status)){
			$data['tid'] = $t->id_str;
			$data['uid'] = $t->user->id;
			$data['uname'] = $t->user->name;
			$data['uloc'] = $t->user->location;
			$data['ufollowers'] = $t->user->followers_count;
			$data['ulang'] = $t->user->lang;
			$data['content'] = $t->text;
			$data['time'] = strtotime($t->created_at);
			insertTweet($data['tid'], $data['uid'], $data['uname'], $data['uloc'], $data['ufollowers'], $data['ulang'], $data['content'], $query, $data['time']);
		}
	}
}

$query = array(
	'#jobsearch',
	'"lost my job"',
	'"find a new job"',
	'"to get a job"',
	'"need a new job"',
	'"look for a job"',
	'#needjob'
	);

$i = 1;
while(1){
	foreach ($query as $q) {
		searchTweet($q);
	}
	echo $i.date(") Y-m-d H:i", time())."\n";
	sleep(45);
	$i++;
}
?>
<script language="javascript">   
  setTimeout("window.parent.location.href='index.php'",3000);   
</script>