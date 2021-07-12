<?php
$path = __DIR__ . DIRECTORY_SEPARATOR . '/includes/sopt1_2.sqlite';
$db = new SQLite3($path);
if (!$db) {
    echo $db->lastErrorMsg();
} else {
    echo "db successfully \n";
}
$sql = "create table cms_shop_items
(
    id int auto_increment primary key,
    category_id mediumint not null,
    vendor_id mediumint not null,
    art_no varchar(255) not null,
    title varchar(255) not null,
    shortdesc text not null,
    description longtext not null,
    metakeys varchar(250) not null,
    metadesc varchar(250) not null,
    ves float not null,
    vol float not null,
    longest_side float default 0 not null,
    price float not null,
    opt float not null,
    kropt float not null,
    nareal float not null,
    old_price float not null,
    published tinyint not null,
    pubdate date not null,
    is_hit tinyint not null,
    is_front tinyint not null,
    is_digital tinyint not null,
    seolink varchar(255) not null,
    qty int not null,
    qty_from_vendor int not null,
    img_count tinyint not null,
    filename varchar(100) null,
    filename_orig varchar(250) not null,
    filesize int not null,
    filedate date not null,
    hits int not null,
    tpl varchar(50) default 'com_inshop_item.tpl' not null,
    url varchar(200) not null,
    rating float default 0 not null,
    rating_votes int default 0 not null,
    external_id varchar(250) not null,
    kaspikz varchar(255) not null,
    is_spec tinyint not null,
    ven_code varchar(255) not null,
    modified tinyint(1)  default 0 not null,
    update_at datetime not null,
    sorting int not null
)";

$result = $db->exec($sql);
echo $db->lastErrorMsg();
$db->close();
//$mysqli = new mysqli('localhost', 'root', '', 'sopt1_2');
//$result = $mysqli->query("SELECT * FROM cms_vendors_params");
//
//var_dump('<pre>', $result->fetch_all(), '</pre>');

//$arr = [
//    'V.Pakhomov@sanmarket.kz'
//];
//
//$link = mysqli_connect('localhost', 'root', '', 'sopt1_2');
//
//$result = mysqli_query($link, "SELECT * FROM cms_vendors_params WHERE ");
//
//var_dump('<pre>', mysqli_fetch_all($result), '</pre>');


//include_once __DIR__ . '/classes/LoadFilesInFolder.php';
//
//$pathToFolder = 'tmp' . DIRECTORY_SEPARATOR;
//
//$class = new LoadFilesInFolder($pathToFolder);
//
//
//$folders = $class->getDirectioryUpdatedToday();



//foreach ($folders as $index => $folder) {
//    $filesFromDirectory = $class->getEntityInDirector($folder);
//    var_dump($filesFromDirectory);
//}
//$files = $class->isUpdateToday();

//var_dump('<pre>', $files, '</pre>');


//$folders = $class->getEntityInDirector();
//
//foreach ($folders as $index => $folder) {
//
//    $listFiles[$folder] = $class->getEntityInDirector($folder);
//
//}

