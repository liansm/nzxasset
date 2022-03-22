<?php

	header('Access-Control-Allow-Origin:*');
	header('Content-type:application/json;charset=utf8');

	$db_link = mysql_connect('localhost', 'nzx_perf_user', '123456');
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

	$query = "select MapID, PathName, GameTime, GameWeather, RunDate, RunTime, PerfAutoRunID, CreateTime from nzx_perf_autorun_data order by PerfAutoRunID desc limit 100";
	$result = mysql_query($query);
	if(!$result){
		echo "fail to get the run data\n";
		exit(-1);
	}

	$perf_result = array();
	while($row = mysql_fetch_assoc($result)){
		$perf_result[] = $row;
	}	

	
	echo json_encode($perf_result);
	mysql_close($db_link);

?>
