<?php
include('db.php');
include('function.php');
$tid = htmlspecialchars($_POST['tid']);
$val = get_real_val($tid);
$query = mysql_query("SELECT * FROM `tweets` WHERE (`ulang` = 'en' OR `ulang` = 'en-gb') AND `related` = '".rand_case()."' AND `tid` != '".$tid."' AND `done` = '0' LIMIT ".(time()%147).",1");
$row = mysql_fetch_array($query);
echo json_encode(array('tid' => $row['tid'], 'cont' => $row['content']));
?>