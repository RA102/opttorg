<?php
error_reporting(E_ALL);

$file = fopen('../listCity.csv', 'w+');

$ch = curl_init();

curl_setopt_array($ch, [
    CURLOPT_URL => 'https://jet7777.ru/cabinet/cities.csv',
    CURLOPT_POST => 'true',
    CURLOPT_INFILE => $file,
]);
ob_start();
$output = curl_exec($ch);
fwrite($file, ob_get_clean());
curl_close($ch);
fclose($file);
