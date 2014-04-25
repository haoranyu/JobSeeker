<?php
include('db.php');
include('function.php');
include('lang.php');
include('load.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo TITLE;?></title>
<link rel="stylesheet" href="style/style.css">
</head>
<body>
	<div class="main">
		<div class="title">
			<?php echo TITLE;?>
		</div>
		<div class="stat">
			<?php echo ALREADY;?>:
			<span id="num"><?php echo $num;?></span>
			<?php echo UNIT;?> - <?php echo CORR_RATE;?>: 
			<span id="rate"><?php echo $acc;?></span>%
		</div>
		<div class="story" id="story"></div>
		<div class="para" id="para">
			<?php echo DESCR;?>
		</div>
	</div>
	<div class="load">
		<div class="content" id="content"><?php echo LOADING;?></div>
	</div>
	<div class="judge" id="judge">
		<div class="case case-yes" id="yes"><?php echo YES_RES;?></div>
		<div class="case case-skip" id="skip"><?php echo SKIP_RES;?></div>
		<div class="case case-no" id="no"><?php echo NO_RES;?></div>
	</div>
	<div class="clear"></div>
	<div class="user">
		<?php echo UID;?>： <?php echo $user; ?>
	</div>
	<div class="footer">
		<?php echo FOOTER;?>
	</div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript">
		var my_tid = '0';
		$(document).on("click","#yes",function() {
			$.ajax({
		        url: 'true.php',
		        type: 'POST',
		        data:{tid: my_tid, user: '<?php echo $user;?>'},
		        dataType: 'json',
		        timeout: 20000,
		        error:  function(){
		        	alert('<?php echo ERROR;?>');
		    	},
		        success: function(data){
		        	if(data == false){
		        		$('#story').text('<?php echo KNOW;?>');
		        		fetch_tweet();
		        	}
		        	else{
			        	story(data.flag, data.acc);
			        	$('#num').text(data.num);
			        	$('#rate').text(data.acc);
			        	fetch_tweet();
			        	$('#para').text('<?php echo SHOW_DESCR;?>');
		        	}
		    	}
		    });
		});
		$(document).on("click","#skip",function() {
			fetch_tweet();
			$('#para').text('<?php echo SHOW_DESCR;?>');
		});
		$(document).on("click","#no",function() {
			$.ajax({
		        url: 'false.php',
		        type: 'POST',
		        data:{tid: my_tid, user: '<?php echo $user;?>'},
		        dataType: 'json',
		        timeout: 20000,
		        error:  function(){
		        	alert('<?php echo ERROR;?>');
		    	},
		        success: function(data){
		        	if(data == false){
		        		$('#story').text('<?php echo KNOW;?>');
		        		fetch_tweet();
		        	}
		        	else{
		        		story(data.flag, data.acc);
			        	$('#num').text(data.num);
			        	$('#rate').text(data.acc);
			        	fetch_tweet();
			        	$('#para').text('<?php echo SHOW_DESCR;?>');
		        	}
		    	}
		    });
		});
		$(document).on("click","#para",function() {
			$(this).html('<?php echo DESCR;?>');
		});
		function fetch_tweet(){
			$('#content').text('<?php echo LOADING;?>');
			$('#judge').slideUp();
			$.ajax({
		        url: 'fetch.php',
		        type: 'POST',
		        data:{tid: my_tid},
		        dataType: 'json',
		        timeout: 20000,
		        error:  function(){
		        	alert('<?php echo ERROR;?>');
		    	},
		        success: function(data){
		        	if(data == false){
		        		$('#content').text('<?php echo FINISH;?>');
		        		$('#judge').text('');
		        	}
		        	else{
		        		my_tid = data.tid;
		            	$('#content').text(data.cont);
		        	}
		        	$('#judge').slideDown();
		    	}
		    });
		}
		function story(flag, acc){
			if(flag == -1){
				if(acc > 70){
        			$('#story').text('<?php echo UNKNOW_70;?>');
        		}
        		else if(acc > 50){
        			$('#story').text('<?php echo UNKNOW_50;?>');
        		}
        		else{
        			$('#story').text('<?php echo UNKNOW_0;?>');
        		}
        		
        	}
        	else if(flag == 0){
        		$('#story').text('<?php echo FALSE_0;?>');
        	}
        	else{
        		if(acc > 70){
        			$('#story').text('<?php echo TRUE_70;?>');
        		}
        		else if(acc > 50){
        			$('#story').text('<?php echo TRUE_50;?>');
        		}
        		else{
        			$('#story').text('<?php echo TRUE_0;?>');
        		}
        	}
		}
		fetch_tweet();
	</script>
</body>
</html>
