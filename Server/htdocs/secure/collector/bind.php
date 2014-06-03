<?php 

mysql_connect("localhost","apache","Ut59mHr2K5dNTNXV");
mysql_select_db("cadb");
mysql_set_charset("utf8"); 


$user_id = $_COOKIE['id'];
$job_id = $_POST['job_id'];

mysql_query("UPDATE job SET id_collector=$user_id WHERE id=$job_id;");

header('Location: https://localhost/secure/collector/debtors_free.php');
exit;

?>
