<?php 

mysql_connect("localhost","apache","Ut59mHr2K5dNTNXV");
mysql_select_db("cadb");
mysql_set_charset("utf8"); 


$last_name = $_POST['last_name'];
$first_name = $_POST['first_name'];
$middle_name = $_POST['middle_name'];
$passport = $_POST['passport'];
$sum = $_POST['sum'];
$name = $_POST['name'];
$number = $_POST['number'];

mysql_query("INSERT INTO debtor (last_name, first_name, middle_name, passport) VALUES ('$last_name', '$first_name', '$middle_name', '$passport');");
$result = mysql_query("SELECT id FROM debtor WHERE passport='$passport';");
$id_debtor = mysql_result($result, 0);

mysql_query("INSERT INTO creditor (name, registration_number) VALUES ('$name', '$number');");
$result = mysql_query("SELECT id FROM creditor WHERE registration_number='$number';");
$id_creditor = mysql_result($result, 0);

mysql_query("INSERT INTO contract (id_creditor, id_debtor, sum) VALUES ($id_creditor, $id_debtor, '$sum');");

header('Location: https://localhost/secure/manager/contract.php');
exit;

?>
