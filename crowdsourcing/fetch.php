<?php
include('db.php');
include('config.php');
include('function.php');
$tid = htmlspecialchars($_POST['tid']);
$val = get_real_val($tid);
$related = rand_case();

if($related == 1){
	$query = mysql_query("SELECT * FROM `tweets` WHERE (`ulang` = 'en' OR `ulang` = 'en-gb') AND `related` = '1' AND `tid` != '".$tid."' AND `done` = '0' LIMIT ".(time()%$cold_start_true).",1");
}
else if($related == 0){
	$query = mysql_query("SELECT * FROM `tweets` WHERE (`ulang` = 'en' OR `ulang` = 'en-gb') AND `related` = '0' AND `tid` != '".$tid."' AND `done` = '0' LIMIT ".(time()%$cold_start_false).",1");
}
else{
	$num = mysql_num_rows(mysql_query("SELECT * FROM `tweets` WHERE (`ulang` = 'en' OR `ulang` = 'en-gb') AND `related` = '-1' AND `tid` != '".$tid."' AND `done` = '0' "));
	$query = mysql_query("SELECT * FROM `tweets` WHERE (`ulang` = 'en' OR `ulang` = 'en-gb') AND `related` = '-1' AND `tid` != '".$tid."' AND `done` = '0' LIMIT ".(time()%($num-1)).",1");
}

$row = mysql_fetch_array($query);
echo json_encode(array('tid' => $row['tid'], 'cont' => $row['content']));
?>
