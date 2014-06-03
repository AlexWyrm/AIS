<?php 

if(isset($_POST['cancel'])) {
	header('Location: https://localhost/secure/collector/debtors_list.php');
	exit;
}

mysql_connect("localhost","apache","Ut59mHr2K5dNTNXV");
mysql_select_db("cadb");
mysql_set_charset("utf8"); 


$user_id = $_COOKIE['id'];
$residue = $_POST['residue'];
$status = $_POST['status'];
$job_id = $_POST['job_id'];

if(!mysql_query("SELECT * FROM job_info_extended WHERE id=$job_id AND id_collector=$user_id;")) {
	header('Location: https://localhost/secure/collector/debtors_list.php');
	exit;
}
mysql_query("UPDATE job SET status='$status' WHERE id=$job_id;");
$result = mysql_query("SELECT contract.id FROM job JOIN contract ON id_contract=contract.id WHERE job.id=$job_id;");
$contract_id = mysql_result($result, 0);
mysql_query("UPDATE contract SET residue='$residue' WHERE id=$contract_id;");

header('Location: https://localhost/secure/collector/debtors_list.php');
exit;

?>
