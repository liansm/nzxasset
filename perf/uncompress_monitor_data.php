<?php

	$content = file_get_contents("./test");
	$uncompress_content = gzuncompress($content);
	$context_length_str = substr($uncompress_content, 0, 4);

	$context_length_arr = unpack("L", $context_length_str);
	$context_length = $context_length_arr[1];

	echo "context_length: $context_length \n";
	$context_json_str = substr($uncompress_content, 4, $context_length);

	$context_fp = fopen("./context.json", "w");
	fwrite($context_fp, $context_json_str);
	fclose($context_fp);


	$data_length_str = substr($uncompress_content, 4+$context_length, 4);
	$data_length_arr = unpack("L", $data_length_str);
	$data_length = $data_length_arr[1];

	echo "data_length: $data_length \n";
	$data_json_str = substr($uncompress_content, 4+$context_length+4, $data_length);

	$fp_data = fopen("./data.json", "w");
	fwrite($fp_data, $data_json_str);
	fclose($fp_data);

	$upload_controller = new PerfUploadController();
	$upload_controller->UploadAction($filename, $perf_data_str, $context_json_str);
?>


