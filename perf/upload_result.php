<?php

require_once('Controller/Perf/PerfUploadController.php');

if(!isset($_SERVER['HTTP_FILENAME']) || empty($_SERVER['HTTP_FILENAME'])){
	echo "FileName is not set";
	exit(-1);
}

$filename = $_SERVER['HTTP_FILENAME'];
$test_local = false;
if($test_local){
	$fp = fopen("./test", "w");
	if(!$fp){
		echo "fail to open the file";
		exit(-1);
	}

	$content = file_get_contents("php://input");
	fwrite($fp, $content);
	fclose($fp);
	return;
}
else
{
	$content=file_get_contents("php://input");
	$uncompress_content = gzuncompress($content);
	$context_length_str = substr($uncompress_content, 0, 4);

	$context_length_arr = unpack("L", $context_length_str);
	$context_length = $context_length_arr[1];
	$context_json_str = substr($uncompress_content, 4, $context_length);

	$perf_data_length_str = substr($uncompress_content, 4+$context_length, 4);
	$perf_data_length_arr = unpack("L", $perf_data_length_str);
	$perf_data_length = $perf_data_length_arr[1];
	$perf_data_str = substr($uncompress_content, 4+$context_length+4, $perf_data_length);


	$upload_controller = new PerfUploadController();
	$upload_controller->UploadAction($filename, $perf_data_str, $context_json_str);
}

?>
