<?php
//Load Headers
header('Content-Type: application/json');
header('Cache-Control: no-cache');
date_default_timezone_set("UTC");

//Starting Array
$statsArray = array();
$statsArray["cpu"]       = sys_getloadavg();
$statsArray["mem_free"]  = shell_exec("free -m | grep Mem | awk '{print ($3+$5)/1000}'");
$statsArray["mem_total"] = shell_exec("cat /proc/meminfo | grep MemTotal | awk '{print $2/(1000*1000)}'");
$statsArray["hdd"]       = shell_exec("df --output=pcent /mnt | tr -dc '0-9'");
$statsArray["upt"]       = shell_exec("uptime -p");
$statsArray["time"]      = time();

$path = realpath(dirname(__FILE__));
echo json_encode($statsArray);

//Save Values for Nextime.
$file=$path."/sys_stat_log.json";
$current = json_encode( $statsArray );
//file_put_contents( $file, $current.PHP_EOL, FILE_APPEND | LOCK_EX);

exit;
?>
