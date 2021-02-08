<?php
$codes = array(
       500 => array('500. Internal Server Error', 'Уважаемый посетитель! На сервере произошла ошибка. Приносим свои извинения за временные неудобства!'),
       501 => array('501. Not Implemented', 'Уважаемый посетитель! На сервере произошла ошибка. Приносим свои извинения за временные неудобства!'),
       502 => array('502. Bad Gateway', 'Уважаемый посетитель! На сервере произошла ошибка. Приносим свои извинения за временные неудобства!'),
       503 => array('503. Service Unavailable', 'Уважаемый посетитель! На сервере произошла ошибка. Приносим свои извинения за временные неудобства!'),
       504 => array('504. Gateway Timeout', 'Уважаемый посетитель! На сервере произошла ошибка. Приносим свои извинения за временные неудобства!'),
       505 => array('505. HTTP Version Not Supported', 'Уважаемый посетитель! На сервере произошла ошибка. Приносим свои извинения за временные неудобства!'),
       507 => array('507. Insufficient Storage', 'Уважаемый посетитель! На сервере произошла ошибка. Приносим свои извинения за временные неудобства!'),
       510 => array('510. Not Extended', 'Уважаемый посетитель! На сервере произошла ошибка. Приносим свои извинения за временные неудобства!'),
);

if (isset($_SERVER['REDIRECT_STATUS'])){
    $status = $_SERVER['REDIRECT_STATUS'];
    $title = ' '.$codes[$status][0];
    $message = $codes[$status][1];
}

if(!isset($title)){
    $title = 'Никакой ошибки нет, всё в порядке!';
	$message = 'Но Вам сюда всё равно нельзя, к сожалению!';
}
?>	
<html>
    <head>
        <meta charset="utf-8">
		<title><?php echo $title; ?></title>
		<style>
			h1, h2, h3 {margin:0;}
			.table {display:table;position:relative;width:100%;height:100vh;}
			.cell {display:table-cell;position:relative;width:100%;height:100vh;vertical-align:middle;text-align:center;}
		</style>
		<link rel="icon" type="image/svg" href="/images/favicon.svg" />
	</head>
	<body>
		<div class="table">
			<div class="cell">
				<a href="/"><img src="https://sanmarket.kz/templates/basic_free/img/logo.png" width="240" /></a><br />
				<h1><?php echo $title; ?></h1>
				<h2><?php echo $message; ?></h2>
				<p>Вы можете перейти <a href="/">на главную</a>, или попытаться <a href="javascript:window.location.reload();">обновить</a> эту страницу через некоторое время.<br />По любым вопросам просим обращаться по телефонам: <strong>+7 7212 50 32 72</strong> или <strong>+7 777 540 99 27</strong></p>
			</div>
		</div>
	</body>
</html>