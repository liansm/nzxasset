<?php

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

	$query = "select PerfAutoRunID, MapID, PathName, GameTime, GameWeather, RunDate, RunTime from nzx_perf_autorun_data order by PerfAutoRunID desc";
	$result = mysql_query($query);
	if(!$result){
		echo "fail to get the run data\n";
		exit(-1);
	}

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

	while($row = mysql_fetch_assoc($result))
	{
		echo "<tr>";
		echo "<td>" .  $row['MapID'] . "</td>";
		echo "<td>" .  $row['PathName'] . "</td>";
		echo "<td>" .  intval($row['GameTime']) . "点</td>";
		echo "<td>" .  $row['GameWeather'] . "</td>";
		echo "<td>" .  $row['RunDate'] ."-" . $row['RunTime'] .  "</td>";
		echo "</tr>";
	}
	
	echo "</table>";

?>
