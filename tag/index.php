<?php
include('db.php');
include('function.php');
if(!isset($_COOKIE['user'])){
	$user = rand_str();
	setcookie("user", $user, time()+3600*24*365);
//	$query = "INSERT INTO `twitter_accuracy`(`user`, `hit`, `sum`) VALUES ('".$user."', '0', '0')";
	echo $query;
	mysql_query($query);
	$acc = 0;
	$num = 0;
}
else{
	$user = htmlspecialchars($_COOKIE['user']);
	$acc = get_acc($user)*100;
	$num = get_num($user);
}

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>数据小游戏：你知道美国佬有多惨吗?</title>
<style>
.para p{
	line-height:24px;
	margin: 0 auto;
}
.para .center{
	text-align: center;
}
</style>
</head>
<body style="text-align:center;margin:0;padding:0;background:#333;">
	<div style="background:#333;padding:30px 0;margin:0; color:#eee">
		<div style="width:80%; margin:0 auto;font-size:26px">数据小游戏：你知道美国佬有多惨吗?</div>
		<div style="width:80%; margin:0 auto;font-size:26px;margin-top:10px">已经判断:<span id="num"><?php echo $num;?></span>条 - 正确率: <span id="rate"><?php echo $acc;?></span>%</div>
		<div style="width:80%; margin:0 auto;font-size:26px;margin-top:10px" id="story"></div>
		<div style="width:80%; margin:10px auto; font-size:14px; text-align:left;" class="para" id="para">
			<p>俞昊然同学正在做一个关于美国就业情况的数据研究，由于昊然同学英语不够好，在理解美国人的情感的时候，多少会出现一些错误。于是做了这个小游戏，希望你能坚持玩上几分钟，帮助一下昊然同学。</p>
			<p><b>>>游戏玩法如下(正确率在75%或以上的同学，每判断500条, 请到微博找“@俞昊然”要5元手机充值或等价商品，二十元起兑……):</b></p>
			<p>&nbsp; &nbsp;1. 游戏开始时，下面的白色区域会显示出一个美国人发的Tweet（类似于中国的微博）</p>
			<p>&nbsp; &nbsp;2. 如果你觉得这个发出信息的人，自身、当前有极强的寻找工作的需求，请点击左侧绿色部分</p>
			<p>&nbsp; &nbsp;3. 不是自己要找工作，或者是招人招不到，或者是某人纯粹对于工作的吐嘈，请点击右侧红色部分</p>
			<p>&nbsp; &nbsp;4. 每次操作后，系统会判断你的判定与大多数用户观点的一致性，并且给你一个评价</p>
		</div>
	</div>
	<div style="background:#ecf0f1;padding:50px 0;margin:0;font-size:26px">
		<div style="width:80%; margin:0 auto" id="content"></div>
	</div>
	<div style="font-size:20px;cursor:pointer;color:#fff;font-weight:bold">
		<div style="width:40%;float:left;background:#27ae60;padding:100px 0;" id="yes">上面是需要找工作的(或刚失业)人发的求工作的内容</div>
		<div style="width:20%;float:left;background:#e67e22;padding:100px 0;" id="skip">我不去确定 - 跳过</div>
		<div style="width:40%;float:left;background:#c0392b;padding:100px 0;" id="no">上面是介绍工作的广告/介绍找工作经验等非表达找工作需求的内容</div>
	</div>
	<div style="font-size:20px; color:#fff; font-weight:bold; font-size:14px;line-height:30px">兑换凭证号： <?php echo $user; ?></div>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
	<script type="text/javascript">
		var my_tid = '0';
		$(document).on("click","#yes",function() {
			$.ajax({
		        url: 'true.php',
		        type: 'POST',
		        data:{tid: my_tid, user: '<?php echo $user;?>'},
		        dataType: 'json',
		        timeout: 8000,
		        error:  function(){
		        	alert('哎哟妈呀，系统卡了一下，再试下……求你啦……帮帮昊然吧……');
		    	},
		        success: function(data){
		        	story(data.flag, data.acc);
		        	$('#num').text(data.num);
		        	$('#rate').text(data.acc);
		        	fetch_tweet();
		        	$('#para').text('>>展开小游戏详细的说明');
		    	}
		    });
		});
		$(document).on("click","#skip",function() {
			fetch_tweet();
			$('#para').text('>>展开小游戏详细的说明');
		});
		$(document).on("click","#no",function() {
			$.ajax({
		        url: 'false.php',
		        type: 'POST',
		        data:{tid: my_tid, user: '<?php echo $user;?>'},
		        dataType: 'json',
		        timeout: 8000,
		        error:  function(){
		        	alert('哎哟妈呀，系统卡了一下，再试下……求你啦……帮帮昊然吧……');
		    	},
		        success: function(data){
		            story(data.flag, data.acc);
		        	$('#num').text(data.num);
		        	$('#rate').text(data.acc);
		        	fetch_tweet();
		        	$('#para').text('>>展开小游戏详细的说明');
		    	}
		    });
		});
		$(document).on("click","#para",function() {
			$(this).html('<p>俞昊然同学正在做一个关于美国就业情况的数据研究，由于昊然同学英语不够好，在理解美国人的情感的时候，多少会出现一些错误。于是做了这个小游戏，希望你能坚持玩上几分钟，帮助一下昊然同学。</p><p><b>>>游戏玩法如下(正确率在75%或以上的同学，每判断500条, 请到微博找“@俞昊然”要5元手机充值或等价商品，二十元起兑……):</b></p><p>&nbsp; &nbsp;1. 游戏开始时，下面的白色区域会显示出一个美国人发的Tweet（类似于中国的微博）</p><p>&nbsp; &nbsp;2. 如果你觉得这个发出信息的人，自身、当前有极强的寻找工作的需求，请点击左侧绿色部分</p><p>&nbsp; &nbsp;3. 不是自己要找工作，或者是招人招不到，或者是某人纯粹对于工作的吐嘈，请点击右侧红色部分</p><p>&nbsp; &nbsp;4. 每次操作后，系统会判断你的判定与大多数用户观点的一致性，并且给你一个评价</p>');
		});
		function fetch_tweet(){
			$.ajax({
		        url: 'fetch.php',
		        type: 'POST',
		        data:{tid: my_tid},
		        dataType: 'json',
		        timeout: 8000,
		        error:  function(){
		        	alert('哎哟妈呀，系统卡了一下，再试下……求你啦……帮帮昊然吧……');
		    	},
		        success: function(data){
                            //console.log(data);
		            my_tid = data.tid;
		            $('#content').text(data.cont);
		    	}
		    });
		}
		function story(flag, acc){
			if(flag == -1){
				if(acc > 70){
        			$('#story').text('哎哟……你刚刚判断的这条昊然其实纠结着呢……感谢你帮昊然做了判断。昊然跪地给您磕头了……');
        		}
        		else if(acc > 50){
        			$('#story').text('哎哟……你刚刚判断的这条昊然其实纠结着呢……加油，帮助昊然一起弄懂美国佬……');
        		}
        		else{
        			$('#story').text('');
        		}
        		
        	}
        	else if(flag == 0){
        		$('#story').text('哎哟……看起来你和昊然在这个问题上都犯错了……大部分人觉得发帖这人不需要找工作吖……');
        	}
        	else{
        		if(acc > 70){
        			$('#story').text('又判断对了一个，昊然特别特别感谢你呢！');
        		}
        		else if(acc > 50){
        			$('#story').text('哎哟，我也看出来你的纠结了，不过你又答对一个，昊然还是要感谢你的！');
        		}
        		else{
        			$('#story').text('哎哟……怎么昊然越来越晕了……求拯救吖……求认真的帮助昊然判断吖……');
        		}
        	}
		}
		fetch_tweet();
	</script>
</body>
</html>
