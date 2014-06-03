<?php

mysql_connect("localhost","apache","Ut59mHr2K5dNTNXV");
mysql_select_db("cadb");
mysql_set_charset("utf8");
	
$result=mysql_query("SELECT * FROM job_info_extended;");

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
	echo "		\"creditor\": \"".htmlspecialchars($row['creditor'])."\"\n";
		
	$i++;
}

echo "		}\n	]\n}";

?>
