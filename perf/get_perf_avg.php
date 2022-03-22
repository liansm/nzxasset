<?php
	header('Access-Control-Allow-Origin:*');
	header('Content-type:application/json;charset=utf8');

	if(!isset($_GET['run_id']) || empty($_GET['run_id'])){
		echo "run_id is not set \n";
		exit(-1);
	}

	//取连续多少帧的平均值
	if(!isset($_GET['frame_count']) || empty($_GET['frame_count'])){
		echo "frame_count is not set \n";
		exit(-1);
	}

	if(!isset($_GET['request_param']) || empty($_GET['request_param'])){
		echo "request_param is not set \n";
		exit(-1);
	}


	$run_id = $_GET['run_id'];
	$frame_count = $_GET['frame_count']; 

	//read the param definition from the header file
	$file_handle = @fopen("./header", "r");

	$param_array = array();
	while( ($buffer = fgets($file_handle, 256)) !== false){
		$param_str = trim($buffer);
		$param_array[] = $param_str;
	}
	fclose($file_handle);


	//check the param request 
	$request_param = $_GET['request_param'];
	$request_param_arr = explode(",", $request_param);
	foreach($request_param_arr as $param){
		if(!in_array($param, $param_array)){
			echo "param is not exist, param=$request_param \n";
			exit(-1);
		}	
	}


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

	$query = "select MapID, PathName, GameTime, GameWeather, RunDate, RunTime, PerfAutoRunID from nzx_perf_autorun_data where PerfAutoRunID = $run_id";
	$result = mysql_query($query);
	if(!$result){
		echo "fail to get the run data\n";
		exit(-1);
	}
	$result_array = array();
	$row = mysql_fetch_assoc($result);
	$result_array['MapID'] = $row['MapID'];
	$result_array['PathName'] = $row['PathName'];
	$result_array['GameTime'] = $row['GameTime'];
	$result_array['GameWeather'] = $row['GameWeather'];
	$result_array['RunDate'] = $row['RunDate'];
	$result_array['RunTime'] = $row['RunTime'];
	$result_array['RunID'] = $row['PerfAutoRunID'];
	
	
	$query_str = "select ";
	foreach($request_param_arr as $param){
		$query_str = $query_str . $param . ",";

	}


	//get the result from the db
	$query_str= rtrim($query_str, ",");
	$query_str = $query_str . " from nzx_perf_autorun_detail_data where PerfAutoRunID = $run_id order by FrameCount";
	$query_result = mysql_query($query_str);
	if($query_result){
		foreach($request_param_arr as $param){
			$result_array[$param] = array();
			$total_value[$param] = 0; 

		}

		$index = 0;
		while($row = mysql_fetch_assoc($query_result)){

			++$index;
			foreach($request_param_arr as $param){
				$val = $row[$param];
				$total_value[$param] += $val; 
			}

			if(($index % $frame_count) == 0){
				foreach($request_param_arr as $param){
					$avg_value = $total_value[$param] / $frame_count;	
					array_push($result_array[$param], $avg_value);
					$total_value[$param] = 0; 
				}	
				$index = 0;
			}
		}

		//TBD: 这里扔掉了最后一些帧(最后一些帧一般不太重要，扔掉算了)

		echo json_encode($result_array);
		mysql_free_result($query_result);
		mysql_close($db_link);

	}
	else{
		$fail_reason = mysql_error($db_link);
		mysql_close($db_link);
		echo "fail to get the data, reason=$fail_reason \n";
		exit(-1);

	}



?>
