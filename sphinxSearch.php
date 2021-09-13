<?php

const USER = 'root';
const PASSWORD = 'rTa354rDVb';
const HOST = '127.0.0.1'; //'185.116.194.174';
const DB = 'sopt1';
const PORT = 9206;

$dsn = "mysql:host=" . HOST . ';port=' . PORT;
$pdo = new PDO($dsn, USER, PASSWORD);
$searchQuery = "SELECT id FROM indx_items WHERE MATCH ('унитаз')";
$result = $pdo->query($searchQuery);
//$squery = 'SELECT i.id, i.title FROM cms_shop_items i WHERE i.id = :id';
$resultId = [];
foreach ($result as $index => $row) {
//    $stm = $pdo->prepare($squery);
//    $stm->execute([':id' => $row['id']]);

    $resultId[] = $row['id'];
    echo '<pre>';
    print_r($row['id']);
    echo '</pre>';
}

$strId = implode(',', $resultId);

$dsn2 = "mysql:dbname=sopt1;host=localhost";

$pdo2 = new PDO($dsn2, USER, PASSWORD);

$sql = "SELECT i.id, i.title FROM cms_shop_items as i WHERE i.id IN ($strId)";


$result2 = $pdo2->query($sql);
$errorInfo = $pdo2->errorInfo();
if($errorInfo[1]) {
    var_dump($pdo2->errorInfo());
} else {
    foreach ($result2 as $index => $item) {
        echo '<pre>';
        print_r($item);
        echo '</pre>';
    }
}