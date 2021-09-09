<?php

const USER = 'root';
const PASSWORD = 'rTa354rDVb';
const HOST = 'localhost';
const DB = 'sopt1';
const POST = 9206;




//$mysqli  = new mysqli(HOST, USER, PASSWORD, DB, 9206);
//$mysqli->set_charset('utf8');
//if ($mysqli->connect_errno) {
//    throw new RuntimeException('ошибка mysqli: ' . $mysqli->connect_error);
//}
//
//
//
//$request = 'унитаз';
//try {
//    $stmt = $mysqli->prepare("SELECT id, title FROM cms_shop_items WHERE  MATCH (?)");
//    var_dump($stmt);
//    $stmt->bind_param('s', $request);
//    $result = $stmt->execute();
//    $stmt->bind_result($id, $title);
//    while ($stmt->fetch()) {
//        printf("%i %s", $id, $title);
//    }
//
//    $stmt->close();
//    $mysqli->close();
//} catch(Exception $exception) {
//    echo $exception->getCode() . ' : ' . $exception->getMessage();
//}
