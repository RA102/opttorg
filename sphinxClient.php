<?php

const USER = 'sopt1'; // sopt1'root';
const PASSWORD = '4B6w0H6y'; //4B6w0H6y 'rTa354rDVb';
const HOST = '185.116.194.174'; //'';
const DB = 'idx_items';
const PORT = 9207;

$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => TRUE,
];

$dsn = "mysql:host=" . HOST . ';port=' . PORT . 'charset=utf8';
$pdo = new PDO($dsn, USER, PASSWORD);
var_dump($pdo->errorInfo());

$searchQuery = "SELECT * FROM idx_items WHERE MATCH ('кран') LIMIT 100";
$result = $pdo->query($searchQuery);
$resultId = [];
var_dump($result);
foreach ($result as $index => $row) {

    $resultId[] = $row['id'];
    echo '<pre>';
    print_r($row);
    echo '</pre>';
}

//$strId = implode(',', $resultId);
//
//$dsn2 = "mysql:dbname=sopt1;host=localhost";
//
//$pdo2 = new PDO($dsn2, USER, PASSWORD);
//
//$sql = "SELECT i.id, i.title, c.id, c.title
//FROM cms_shop_items as i
//JOIN cms_shop_cats as c ON i.category_id = c.id
//WHERE i.id IN ($strId)";
//
//
//$result2 = $pdo2->query($sql);
//$errorInfo = $pdo2->errorInfo();
//if($errorInfo[1]) {
//    var_dump($pdo2->errorInfo());
//} else {
//    var_dump(count($result2));
//    foreach ($result2 as $index => $item) {
//        echo '<pre>';
//        print_r($item);
//        echo '</pre>';
//    }
//}