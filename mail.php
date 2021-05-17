<?php

//header("Content-Type: text/html; charset=utf=8");
//
//error_reporting(0);
//
//$mail_login = "price@sanmarket.kz";
//$mail_password = 'vX1bO3hT7daP5y';
//
//$mail_imap = "{mail.sanmarket.kz:993}";
//
//$mail_filetypes = [
//    "Exel"
//];
//
//$connection = imap_open($mail_imap, $mail_login, $mail_password);
//
//if (!$connection) {
//    echo "Ошибка соединения с почтой - " . $mail_login;
//    exit;
//} else {
//    $msg_num = imap_num_msg($connection);
//    $mails_data = [];
//
//    for ($i = 0; $i <= $msg_num; $i++) {
//        echo $msg_num[$i] . "\n";
//    }
//
//    for ($i = 0; $i <= $msg_header; $i++) {
//        $msg_header = imap_header($connection, $i);
//    }
//}
//
//imap_close($connection);


$headers = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
$headers .= 'To: <price@sanmarket.kz>' . "\r\n";
$headers .= 'From: <ra_lebedev@mail.ru>' . "\r\n";

mail('ra_lebedev@mail.ru', 'test', 'test', $headers, []);