<?php

mysql_connect("localhost","apache","Ut59mHr2K5dNTNXV");
mysql_select_db("cadb");
mysql_set_charset("utf8");

if(isset($_GET['id'])) {
	$id = $_GET['id'];
	$result=mysql_query("SELECT concat(last_name,' ',first_name,' ', middle_name, ' (', passport, ')') FROM collector WHERE id=$id;");
	$collector=mysql_result($result, 0);
} else {
	$collector='Без привязки';
}
$result=mysql_query("SELECT * FROM job_info_extended WHERE (collector='$collector');");

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
	echo "		\"status\": \"".htmlspecialchars($row['status'])."\",\n";
	echo "		\"collector\": \"".$row['collector']."\",\n";
	echo "		\"creditor\": \"".htmlspecialchars($row['creditor'])."\",\n";
	echo "		\"id\": \"".$row['id']."\"\n";
		
	$i++;
}

echo "		}\n	]\n}";

?>
