<?php

include 'core/cms.php';

define('PATH', $_SERVER['DOCUMENT_ROOT']);

$dir = '../cache/';
$filename = 'import.xml';

cmsCore::loadModel('shop');
$model = new cms_model_shop();


//if (file_exists("$dir.$filename")) {

    $z = new XMLReader;
    $z->open($dir . $filename);

    while ($z->read() && $z->name !== 'Товары') ;

    $current_product_num = 0;

    $xml = new SimpleXMLIterator($z->readOuterXML());

    for ($i = 0; $i <= $xml->count(); $i++) {
        import_product($xml->Товар[$i]);
        $current_product_num++;
    }

    $z->close();

//} else {
//
//}


function import_product($xml_product)
{
    $item = [];

    $artNo = (string)$xml_product->Артикул;

    if ($artNo) {
        $product_id = cmsDatabase::getInstance()->get_field('cms_shop_items', 'art_no=' . $artNo , 'id' );
    } else {
        return;
    }



    if (empty($product_id)) {
        $item['category_id'] = 10991;
        $item['art_no'] = (string)$xml_product->Артикул;
        $item['title'] = cmsDatabase::getInstance()->escape_string((string)$xml_product->Наименование);
        $item['price'] = $xml_product->Стоимость;
        $item['published'] = 0;
        $item['pubdate'] = date('Y-m-d');
        $item['qty'] = $xml_product->КоличествоОстаток;
        $item['tpl'] = 'com_inshop_item.tpl';
        $item['external_id'] = (string)$xml_product->Ид;

        $sql = "INSERT INTO cms_shop_items (
                            `category_id`, 
                            `art_no`,
                            `title`, 
                            `price`, 
                            `published`,
                            `pubdate`,
                            `qty`,
                            `tpl`,
                            `external_id`)
				VALUES (
				        '{$item['category_id']}',
				        '{$item['art_no']}',
				        '{$item['title']}',
				        '{$item['price']}',
				        '{$item['published']}',
				         NOW(),
				        '{$item['qty']}',
				        '{$item['tpl']}', 
				        '{$item['external_id']}'
				)";
        $result = cmsDatabase::getInstance()->query($sql);

    } else {
        $item['price'] = (int)$xml_product->Стоимость;
        $item['qty'] = (int)$xml_product->КоличествоОстаток;
        $item['update'] = date('Y-m-d');

        cmsDatabase::getInstance()
            ->update('cms_shop_items', $item, $product_id);
    }

}