<?php

define("DB_USER", "root"); //Пользователь
define("DB_PASSWORD", ""); //Пароль
define("DB_HOST", "localhost"); //Пароль

//$config = cmsConfig::getInstance();
//mb_internal_encoding('utf8');

$link = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, "sopt1_2");

//$word = mysqli_real_escape_string($link, 'Зеркало');

mysqli_set_charset($link, 'UTF-8');
$stmt = mysqli_prepare($link, "SELECT * FROM cms_shop_items WHERE title LIKE ?");
$word = '%Зеркало%';
mysqli_stmt_bind_param($stmt, "s", $word);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);
//var_dump($result);
while($row = mysqli_fetch_array($result)) {
    var_dump($row, "\n");
}


