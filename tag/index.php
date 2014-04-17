<?php
include('db.php');
$query = mysql_query("SELECT * FROM `tweets` WHERE (`ulang` = 'en' OR `ulang` = 'en-gb') AND `related` = '-1' LIMIT 1");
$row = mysql_fetch_array($query);
//print_r($row);
?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Do I need a Job?</title>
<body style="text-align:center;margin:0;padding:0">
	<h1 style="background:#ecf0f1;padding:30px 0;margin:0">
		<div style="width:80%; margin:0 auto"><?php echo $row['content']?></div>
	</h1>
	<div style="font-size:20px;line-height:300px; cursor:pointer;color:#fff;font-weight:bold">
		<div style="width:50%;float:left;background:#27ae60" id="yes">Do need a job</div>
		<div style="width:50%;float:left;background:#c0392b" id="no">Not job seeker</div>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript">
		$(document).on("click","#yes",function() {
			$.ajax({
		        url: 'true.php',
		        type: 'POST',
		        data:{tid: '<?php echo $row['tid'];?>'},
		        dataType: 'json',
		        timeout: 8000,
		        error:  function(){
		        	alert('error');
		    	},
		        success: function(data){
		            if(data){
		            	window.location.reload();
		            }
		    	}
		    });
		});
		$(document).on("click","#no",function() {
			$.ajax({
		        url: 'false.php',
		        type: 'POST',
		        data:{tid: '<?php echo $row['tid'];?>'},
		        dataType: 'json',
		        timeout: 8000,
		        error:  function(){
		        	alert('error');
		    	},
		        success: function(data){
		            if(data){
		            	window.location.reload();
		            }
		    	}
		    });
		});
	</script>
</body>
</html>