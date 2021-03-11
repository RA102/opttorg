<?php

if (isset($_POST['vens47jiklo']) || isset($_POST['catrehiu647uii'])) {
	
header("Content-type: text/csv"); 

header("Content-Disposition: attachment; filename=file.csv"); 

header("Pragma: no-cache"); 

header("Expires: 0");

    define("DB_HOST", "localhost");
    define("DB_NAME", "sopt1"); //Имя базы
    define("DB_USER", "sopt1"); //Пользователь
    define("DB_PASSWORD", "sopt112151"); //Пароль

	$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
	$mysqli -> query("SET NAMES 'utf8'") or die ("Ошибка соединения с базой!");

	$db_referal = $mysqli -> query("SELECT * FROM cms_shop_cats");

	$prods = array();

	while ($row = $db_referal -> fetch_array()) {
		$prods[] = $row;
	}

	$buffer = fopen('php://output', 'w'); 

	fputs($buffer, chr(0xEF) . chr(0xBB) . chr(0xBF));

	foreach($prods as $val) { 

		fputcsv($buffer, $val, ';'); 

	} 

	fclose($buffer); 

	exit();
} else {
	echo 'ХАЦКЕРПШЛНХЙ';
}