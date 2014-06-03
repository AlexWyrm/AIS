<?php

$user = $_SERVER['PHP_AUTH_USER'];
$group_file = fopen("/opt/lampp/passwords/groups.dat", "r");
$line = fgets($group_file);
$line = fgets($group_file);
if(preg_match("/^manager :.* $user(?: .*|$)/", $line)) {
	header('Location: https://localhost/secure/manager/');
	fclose($group_file);
	exit();
}
$line = fgets($group_file);
if(preg_match("/^collector :.* $user(?: .*|$)/", $line)) {
	echo $user;
	header('Location: https://localhost/secure/collector/');
	fclose($group_file);
	exit();
}
$line = fgets($group_file);
if(preg_match("/^creditor :.* $user(?: .*|$)/", $line)) {
	header('Location: https://localhost/secure/creditor/');
	fclose($group_file);
	exit();
}
fclose($group_file);
?>
