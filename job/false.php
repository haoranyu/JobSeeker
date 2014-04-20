<?php
include('db.php');
$tid = htmlspecialchars($_POST['tid']);
$ret = mysql_query("UPDATE `tweets` SET `related`='0',`done`='1' WHERE `tid`='".$tid."'");
echo json_encode($ret);
?>
