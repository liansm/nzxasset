<?php

	if(!isset($_GET['run_id']) || empty($_GET['run_id'])){
		echo "not set the run_id <br />";
		exit(-1);

	}
	$run_id = $_GET['run_id'];

	$db_link = mysql_connect('localhost', 'root', 'ilovezx');
	if(!$db_link){
		echo "连接数据库失败，无法创建 </br>";
		exit(-1);
	}

	$result=mysql_select_db('nzx_perf_data', $db_link);
	if(!$result){
		echo "选择数据库失败，无法创建 </br>";
		exit(-1);
	}


	mysql_query("set names utf8");

	$query = "select MapID, PathName, GameTime, GameWeather, RunDate, RunTime from nzx_perf_autorun_data where PerfAutoRunID=$run_id";
	$result = mysql_query($query);
	if(!$result){
		echo "fail to get the run data\n";
		exit(-1);
	}

/*
	$perf_table_header='<table border="1">
		<tr>
			<th>MapID</th>
			<th>PathName</th>
			<th>GameTime</th>
			<th>GameWeather</th>
			<th>RunTime</th>
		</tr>';	
	echo $perf_table_header;
*/

	$perf_table_header='<table border="1">
		<tr>
			<th>地图ID</th>
			<th>路径名字</th>
			<th>游戏时间</th>
			<th>游戏天气</th>
			<th>实际时间</th>
		</tr>';	
	echo $perf_table_header;

		
	$result = mysql_query($query);
	if(!$result){
		echo "fail to get the data\n";
		exit(-1);
	}

	$row = mysql_fetch_assoc($result);

	echo "<tr>";
	echo "<td>" .  $row['MapID'] . "</td>";
	echo "<td>" .  $row['PathName'] . "</td>";
	echo "<td>" .  intval($row['GameTime']) . "点</td>";
	echo "<td>" .  $row['GameWeather'] . "</td>";
	echo "<td>" .  $row['RunDate'] ."-" . $row['RunTime'] .  "</td>";
	echo "</tr>";
	echo "</table>";


	$query = "select FrameCount, GameThreadTime, RenderThreadTime, RHIThreadTime, GPUTime, FrameTime, RHI_DrawCalls, FrameEvent 
					from nzx_perf_autorun_detail_data where PerfAutoRunID=$run_id order by FrameCount";
	$result = mysql_query($query);
	if(!$result){
		echo "fail to get the detail data\n";
		exit(-1);
	}

	$details = array();
	while($row= mysql_fetch_assoc($result)){
		$value = [ $row['FrameCount'], $row['GameThreadTime'], $row['RenderThreadTime'], $row['RHIThreadTime'], $row['GPUTime'], $row['FrameTime'], $row['RHI_DrawCalls'], $row['FrameEvent'] ];
		array_push($details, $value);
	}

	//去掉第一帧
	array_shift($details);

	$total_frame = 0;
	$total_game_time = 0.0;
	$total_render_time = 0.0;
	$total_rhi_time = 0.0;
	$total_gpu_time = 0.0;
	$total_frame_time = 0.0;

	//计算各个区间里面的个数
	$time_thresholds = [15, 20, 30, 45, 60, 80, 100, 5000];
	$total_count = array();

	//先初始化成0
	foreach($time_thresholds as $time_threshold){
		$init_count = [0, 0, 0, 0, 0];
		array_push($total_count, $init_count);
	}

	foreach($details as $detail){
		++$total_frame;

		$total_game_time += $detail[1];	
		$total_render_time += $detail[2];	
		$total_rhi_time += $detail[3];	
		$total_gpu_time += $detail[4];	
		$total_frame_time += $detail[5];	

		for($index =1; $index <=5; ++$index){
			for($threshold_index = 0; $threshold_index < count($time_thresholds); ++$threshold_index){
				if($detail[$index] <= $time_thresholds[$threshold_index]){
					$total_count[$threshold_index][$index-1] += 1; 
					break;
				}
			}
		}
	}

	echo "<br /> <br />";
	echo "帧率统计概况(总帧数: $total_frame):";
	$perf_summary_header='<table border="1">
		<tr>
			<th></th>
			<th>GameThread</th>
			<th>RenderThread</th>
			<th>RHIThread</th>
			<th>GPU</th>
			<th>Frame</th>
		</tr>';	
	echo $perf_summary_header;

	echo "<tr>";
	echo "<th>平均时间</th>";
	echo "<td>" . round($total_game_time/$total_frame, 2) . "</td>";
	echo "<td>" . round($total_render_time/$total_frame, 2) . "</td>";
	echo "<td>" . round($total_rhi_time/$total_frame, 2) . "</td>";
	echo "<td>" . round($total_gpu_time/$total_frame, 2) . "</td>";
	echo "<td>" . round($total_frame_time/$total_frame, 2) . "</td>";
	echo "</tr>";


	$col_desc = ["<15ms", "15ms-20ms", "20ms-30ms", "30ms-45ms", "45ms-60ms", "60ms-80ms", "80ms-100ms", ">100ms"];
	$index = 0;
	foreach($total_count as $count){
		echo "<tr>";
		echo "<th>" . $col_desc[$index++] .  "</th>";
		foreach($count as $value){
			echo "<td>" . $value . "(" . round($value*100/$total_frame,2) . "%)</td>";
		}
		echo "</tr>";
	}

	echo "</table>";



	echo "<br /> <br />";
	echo "详细情况:";
	$perf_table_detail_header='<table border="1">
		<tr>
			<th>FrameCount</th>
			<th>GameThreadTime(ms)</th>
			<th>RenderThreadTime(ms)</th>
			<th>RHIThreadTime(ms)</th>
			<th>GPUTime(ms)</th>
			<th>FrameTime(ms)</th>
			<th>RHI_DrawCalls</th>
			<th>Event</th>
		</tr>';	
	echo $perf_table_detail_header;

	foreach($details as $detail)
	{
		echo "<tr>";
		echo "<td>" .  $detail[0] . "</td>";
		echo "<td>" .  $detail[1] . "</td>";
		echo "<td>" .  $detail[2] . "</td>";
		echo "<td>" .  $detail[3] . "</td>";
		echo "<td>" .  $detail[4] . "</td>";
		echo "<td>" .  $detail[5] . "</td>";
		echo "<td>" .  $detail[6] . "</td>";

		$event = $detail[7];
		if(strcmp($event, "None") == 0){
			$event = "";
		}
		echo "<td>" .  $event.  "</td>";
		echo "</tr>";
	}
	echo "</table>";
	


?>
