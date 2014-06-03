<html>
<head>
	<title>Новый контракт</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">
	<link href="../resources/CAMS.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" charset="utf8" src="contract.js"></script>
</head>

<?php

if(!mysql_connect("localhost","apache","Ut59mHr2K5dNTNXV"))
	{
		echo "<h2>Невозможно получить доступ к БД</h2>";
		die();
	}
mysql_select_db("cadb");
mysql_set_charset("utf8");  

function getOptions($table, $column, $id) {
	$result=mysql_query("SELECT DISTINCT $column FROM $table;");
	echo "<datalist id=$id>\r\n";
	for($i = 0; $i < mysql_num_rows($result); $i++) {
		echo "<option value=\"".htmlspecialchars(mysql_result($result, $i))."\">\r\n";
	}
	echo "</datalist>";
}

?>

<body>
&nbsp;<p>
<h1>Новый контракт</h1>
<form action=addContract.php method=post>
<table id=contract cellspacing=0 width=50% class=display>
<thead>
	<tr>
		<th></th>
		<th>Значение</th>
		<th></th>
	</tr>
</thead>
<tbody>

	<tr>
		<th>Фамилия</th>
		<th>
			<input list=last_names type=text name=last_name>
			<? getOptions('debtor', 'last_name', 'last_names'); ?>
		</th>
	</tr>
	<tr>
		<th>Имя</th>
		<th>
			<input list=first_names type=text name=first_name>
			<? getOptions('debtor', 'first_name', 'first_names'); ?>
		</th>
	</tr>
	<tr>
		<th>Отчество</th>
		<th>
			<input list=middle_names type=text name=middle_name>
			<? getOptions('debtor', 'middle_name', 'middle_names'); ?>
		</th>
	</tr>
	<tr>
		<th>Паспорт</th>
		<th>
			<input list=passports type=text name=passport>
			<? getOptions('debtor', 'passport', 'passports'); ?>
		</th>
	</tr>
	<tr>
		<th>Сумма долга</th>
		<th>
			<input type=text name=sum>
		</th>
	</tr>
	<tr>
		<th>Кредитор</th>
		<th>
			<input list=names type=text name=name>
			<? getOptions('creditor', 'name', 'names'); ?>
		</th>
	</tr>
	<tr>
		<th>РН кредитора</th>
		<th>
			<input list=numbers type=text name=number>
			<? getOptions('creditor', 'registration_number', 'numbers'); ?>
		</th>
	</tr>
	<tr>
		<th></th>
		<th>
			<input type=submit name=add value="Добавить контракт">
		</th>
	</tr>

</tbody>

</table>
</form>
</body>
</html>
