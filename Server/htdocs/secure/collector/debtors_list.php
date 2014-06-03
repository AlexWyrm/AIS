<?php
	$user = $_SERVER['PHP_AUTH_USER'];
	preg_match('/^co(\d+)/', $_SERVER['PHP_AUTH_USER'], $matches);
	$user_id = $matches[1];
	setcookie("id", $user_id);
?>

<html>
<head>
	<title>Мои должники</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.0/css/jquery.dataTables.css">
	<link href="../resources/CAMS.css" rel="stylesheet" type="text/css">
	<script type="text/javascript" charset="utf8" src="//code.jquery.com/jquery-1.10.2.min.js"></script>
	<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.0/js/jquery.dataTables.js"></script>
	<script type="text/javascript" charset="utf8" src="debtors_list_ajax.js"></script>
</head>

<body>

&nbsp;<p>
<h1>Мои должники</h1>

<table id=list cellspacing=0 width=100% class=display>
<thead>
	<tr>
		<th></th>
		<th>Фамилия</th>
		<th>Имя</th>
		<th>Отчество</th>
		<th>№ паспорта</th>
		<th>Сумма долга</th>
		<th>Остаток</th>
		<th>Статус</th>
	</tr>
</thead>

<tfoot>
	<tr>
		<th></th>
		<th>Фамилия</th>
		<th>Имя</th>
		<th>Отчество</th>
		<th>№ паспорта</th>
		<th>Сумма долга</th>
		<th>Остаток</th>
		<th>Статус</th>
	</tr>
</tfoot>

<tbody>




</tbody>

</table>

</body>
</html>
