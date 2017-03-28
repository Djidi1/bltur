<?php
header('Content-Type: text/html; charset=utf-8');
/*
$handle = @fopen("logs/log_online.txt", "r");
if ($handle) {
	while (($buffer = fgets($handle, 4096)) !== false) {
		echo $buffer;
	}
	fclose($handle);
}
*/

echo file_get_contents("logs/log_online.txt");

?>