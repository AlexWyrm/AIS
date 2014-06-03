<html>
<head>
<title>КА: должник</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>

<? 
	if(!mysql_connect("localhost","apache","Ut59mHr2K5dNTNXV"))
	{
		echo "<h2>Невозможно получить доступ к БД</h2>";
		die();
	}
	mysql_select_db("cadb");
	mysql_set_charset("utf8"); 
	
	if(@$_REQUEST['id']=="") {
		echo "<h2>Недопустимый номер пользователя</h2>";
		die();
	}
	
	$result=mysql_query("SELECT * FROM job_info WHERE id=".@$_REQUEST['id'].";");
	if(!$result) {
		echo "<h2>Не существует такого должника</h2>";
		die();
	}
	
	$debtor=mysql_fetch_array($result);
	
	$update_disabled="";
	$bind_disabled=TRUE;
	$manager=FALSE;
	$user = $_SERVER['PHP_AUTH_USER'];
	if(preg_match('/^\w+([0-9]+)/', $_SERVER['PHP_AUTH_USER'], $matches)) {
		$user_id = $matches[1];
		if($debtor['id_collector']) {
			if($user_id!=$debtor['id_collector']) {
				header('HTTP/1.1 401 Unauthorized', true, 401);
				die();
			}
		} else {
			$update_disabled="disabled";
			$bind_disabled=FALSE;
		}
	} else {
		$manager=TRUE;
		$bind_disabled=FALSE;
	}
	
	if(isset($_GET['update']) && ($debtor['id_collector'] || $manager)) {
		mysql_query("UPDATE contract SET residue=".$_GET['residue']." WHERE id=".$debtor['id_contract'].";");
		mysql_query("UPDATE job SET status=\"".$_GET['status']."\" WHERE id=".@$_REQUEST['id'].";");
		$result=mysql_query("SELECT * FROM job_info WHERE id=".@$_REQUEST['id'].";");
		$debtor=mysql_fetch_array($result);
	}
	
	if(isset($_GET['bind'])) {
		if ($_GET['bind']=='Прикрепить' && (!$debtor['id_collector'])) {
			mysql_query("UPDATE job SET id_collector=\"".$user_id."\" WHERE id=".@$_REQUEST['id'].";");
		} else if($_GET['bind']=='Открепить' && $manager) {
			mysql_query("UPDATE job SET id_collector=NULL WHERE id=".@$_REQUEST['id'].";");
		}
	}
	
?>

&nbsp;<p>
<h1><? echo $debtor['last_name']." ".$debtor['first_name']." ".$debtor['middle_name'] ?></h1>

<table border=0 cellpadding=0 cellspacing=0>
<tr>
<td><img src=blank.gif width=10 height=25></td>
<td class=tabhead><img src=blank.gif width=100 height=6/>
<td><img src=blank.gif width=10 height=25></td>
<td class=tabhead><img src=blank.gif width=300 height=6/>
<td><img src=blank.gif width=10 height=25></td>
</tr>

<form action=debtor.php method=get>


<?

		
		echo "<tr valign=center>";
		echo "<td class=tabval><img src=blank.gif width=10 height=20></td>";
		echo "<td class=tabval>№ паспорта</td>";
		echo "<td class=tabval><img src=blank.gif width=10 height=20></td>";
		echo "<td class=tabval align=right>".htmlspecialchars($debtor['passport'])."&nbsp;</td>";
		echo "<td class=tabval></td>";
		echo "</tr>";
		
		echo "<tr valign=bottom>";
		echo "<td bgcolor=#ffffff background='strichel.gif' colspan=4><img src=blank.gif width=1 height=1></td>";
		echo "</tr>";
		
		echo "<tr valign=center>";
		echo "<td class=tabval><img src=blank.gif width=10 height=20></td>";
		echo "<td class=tabval>Сумма долга</td>";
		echo "<td class=tabval><img src=blank.gif width=10 height=20></td>";
		echo "<td class=tabval align=right>".htmlspecialchars($debtor['sum'])."&nbsp;</td>";
		echo "<td class=tabval></td>";
		echo "</tr>";
		
		echo "<tr valign=bottom>";
		echo "<td bgcolor=#ffffff background='strichel.gif' colspan=4><img src=blank.gif width=1 height=1></td>";
		echo "</tr>";
		
		echo "<tr valign=center>";
		echo "<td class=tabval><img src=blank.gif width=10 height=20></td>";
		echo "<td class=tabval>Остаток</td>";
		echo "<td class=tabval><img src=blank.gif width=10 height=20></td>";
		echo "<td class=tabval align=right><input align=right type=text name=residue value=".htmlspecialchars($debtor['residue'])." ".$update_disabled."/></td>";
		echo "<td class=tabval></td>";
		echo "</tr>";
		
		echo "<tr valign=bottom>";
		echo "<td bgcolor=#ffffff background='strichel.gif' colspan=4><img src=blank.gif width=1 height=1></td>";
		echo "</tr>";
		
		echo "<tr valign=center>";
		echo "<td class=tabval><img src=blank.gif width=10 height=20></td>";
		echo "<td class=tabval>Статус</td>";
		echo "<td class=tabval><img src=blank.gif width=10 height=20></td>";
		echo "<td class=tabval align=right>
			<input list=statuses name=status value=\"".htmlspecialchars($debtor['status'])."\" ".$update_disabled.">
				<datalist id=statuses>
					<option value=\"В ожидании\">
					<option value=\"Поиск должника\">
					<option value=\"Взыскивается\">
					<option value=\"Долг погашен\">
					<option value=\"Дело в суде\">
					<option value=\"Дело проиграно\">
					<option value=\"Истёк срок контракта\">
				</datalist>
			</input></td>";
#		echo "<td class=tabval align=right>
#			<input type=text name=status value=\"".htmlspecialchars($debtor['status'])."\" ".$update_disabled."/>&nbsp;
#		</td>";
		echo "<td class=tabval></td>";
		echo "</tr>";

		echo "<tr valign=bottom>";
        echo "<td bgcolor=#fb7922 colspan=4><img src=blank.gif width=1 height=8></td>";
        echo "</tr>";
        
        echo "<tr valign=center>";
        echo "<td class=tabval><img src=blank.gif width=10 height=20><input type=hidden name=id value=\"".@$_REQUEST['id']."\"/></td>";
		echo "<td class=tabval colspan=3 align=right>";
		echo "<input type=submit name=update value=\"Изменить\"".$update_disabled."/></td>";
		echo "</tr>";
		
		
		echo "<tr valign=center>";
        echo "<td class=tabval><img src=blank.gif width=10 height=20></td>";
		echo "<td class=tabval colspan=3 align=right>";
		if(!$bind_disabled) {
			echo "<input type=submit name=bind value=";
			if($manager) {
				echo "Открепить";
			} else {
				echo "Прикрепить";
			}
			echo " /></td>";
		}
		echo "</tr>";


?>

</table>
</form>

</body>
</html>
