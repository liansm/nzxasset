<?php

require_once('Controller/Perf/PerfUploadController.php');

	$content = file_get_contents("./test");
	$uncompress_content = gzuncompress($content);
	$context_length_str = substr($uncompress_content, 0, 4);

	$context_length_arr = unpack("L", $context_length_str);
	$context_length = $context_length_arr[1];

	echo "context_length: $context_length \n";
	$context_json_str = substr($uncompress_content, 4, $context_length);


	$data_length_str = substr($uncompress_content, 4+$context_length, 4);
	$data_length_arr = unpack("L", $data_length_str);
	$data_length = $data_length_arr[1];

	echo "data_length: $data_length \n";
	$data_json_str = substr($uncompress_content, 4+$context_length+4, $data_length);


	$upload_controller = new PerfUploadController();

	$filename = "8213_path1_10_EWeatherSunny_20220308_103239.csv";

	$upload_controller->UploadAction($filename, $data_json_str, $context_json_str);
?>


