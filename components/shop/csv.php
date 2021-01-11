<?php

if (isset($_POST['vens47jiklo']) || isset($_POST['catrehiu647uii'])) {

	if ($_POST['vens47jiklo']==0) {
	    $vendor = '';
	} else {
	    $vendor = ' AND vendor_id = '.$_POST['vens47jiklo'];
	}

	if ($_POST['catrehiu647uii']==0) {
	    $category = '';
	} else {
	    $category = ' AND category_id = '.$_POST['catrehiu647uii'];
	}
		header("Content-type: text/csv"); 

		header("Content-Disposition: attachment; filename=file.csv"); 

		header("Pragma: no-cache"); 

		header("Expires: 0");	
			

		$hostname="localhost";
		$username="sopt1";
		$password="sopt112151";
		$dbname="sopt1";
		mysqli_connect($hostname,$username, $password) or die ("<html>script language='JavaScript'>alert('Не удается подключиться к базе данных. Повторите попытку позже.'),history.go(-1)/script></html>");
		mysqli_select_db($dbname);
		mysqli_query ("SET NAMES utf8");
		mysqli_query ("set character_set_client='utf8'");
		mysqli_query ("set character_set_results='utf8'");
		mysqli_query ("set collation_connection='utf8_general_ci'");


		$res = mysqli_query("SELECT id, art_no, title, qty, price, old_price, ven_code FROM cms_shop_items WHERE id > 1".$vendor.$category." ORDER BY id ASC");

		$prods = array();

		while($row = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
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