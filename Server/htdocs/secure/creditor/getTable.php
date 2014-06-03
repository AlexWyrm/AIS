<?php

mysql_connect("localhost","apache","Ut59mHr2K5dNTNXV");
mysql_select_db("cadb");
mysql_set_charset("utf8");

$id = $_GET['id'];
$result=mysql_query("SELECT last_name, first_name, middle_name, passport, sum, residue, status FROM job_info WHERE id_collector=$id;");

$i=0;
echo "{\n	\"data\": [ {\n		";

while($row=mysql_fetch_array($result)) {
	if($i > 0) {
		echo "	},\n	{\n		";
	}
	echo "\"last_name\": \"".$row['last_name']."\",\n";
	echo "		\"first_name\": \"".$row['first_name']."\",\n";
	echo "		\"middle_name\": \"".$row['middle_name']."\",\n";
	echo "		\"passport\": \"".$row['passport']."\",\n";
	echo "		\"sum\": \"".$row['sum']."\",\n";
	echo "		\"residue\": \"".$row['residue']."\",\n";
	echo "		\"status\": \"".htmlspecialchars($row['status'])."\"\n";
		
	$i++;
}

echo "		}\n	]\n}";

?>
