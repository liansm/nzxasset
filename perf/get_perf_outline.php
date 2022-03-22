<?php

header('Access-Control-Allow-Origin:*');
header('Content-type:application/json;charset=utf8');

require_once('Controller/Perf/Controller.php');

if(!isset($_GET['run_id']) || empty($_GET['run_id'])){
	echo "run_id is not set \n";
	exit(-1);
}


$run_id = $_GET['run_id'];

$perf_controller = new PerfController();
$perf_controller->GetPerfOutline($run_id);

?>
