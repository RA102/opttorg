<?php
if (!defined('VALID_CMS')) {
    define('VALID_CMS', 1);
}
If(!defined('PATH')) {
    define('PATH', __DIR__ . DIRECTORY_SEPARATOR . '..');
}
class LoadItemXml
{
    protected $simpleXmlIterator;

    public function __construct($pathToXmlFile)
    {
        $this->simpleXmlIterator = simplexml_load_file($pathToXmlFile, 'SimpleXMLIterator');;
    }

    public function iteratorXml()
    {
        $items = ($this->simpleXmlIterator->Каталог)->Товары;
        var_dump($items);
        for ($i = 0; $i <= count($items); $i++) {
            yield $items->Товар[$i];
        }

        return 0;
    }

    public function importProduct()
    {

        include_once PATH . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'config.class.php';
        include_once PATH . DIRECTORY_SEPARATOR . 'core' . DIRECTORY_SEPARATOR . 'classes' . DIRECTORY_SEPARATOR . 'db.class.php';

        if (!$this->simpleXmlIterator) {
            die('file not found');
        }

        $items = ($this->simpleXmlIterator->Каталог)->Товары;
        $instanceDb = cmsDatabase::getInstance();

        for ($i = 0; $i <= count($items->Товар); $i++) {

            $itemArticle = trim($items->Товар[$i]->Артикул);

            if ($itemArticle) {

                $sql = "SELECT id FROM cms_shop_items WHERE art_no LIKE \"$itemArticle\"";
                $result = $instanceDb->query($sql);
                if ($instanceDb->num_rows($result)) {
                    $productId = $instanceDb->fetch_assoc($result);
                }
            } else {
                return 0;
            }

            if (empty($productId['id']) || is_null($productId['id'])) {

                $item['category_id'] = 10991;
                $item['art_no'] = (string)$items->Товар[$i]->Артикул;
                $item['title'] = $instanceDb->escape_string((string)$items->Товар[$i]->Наименование);
                $item['published'] = 0;
                $item['price'] = $items->Товар[$i]->Стоимость;
                $item['pubdate'] = date('Y-m-d');
                $item['qty'] = $items->Товар[$i]->КоличествоОстаток;
                $item['tpl'] = 'com_inshop_item.tpl';
                $item['external_id'] = (string)$items->Товар[$i]->Ид;

                $lastIdInTable = $instanceDb->insert('cms_shop_items', $item);
                $sql = "SELECT MAX(ordering) FROM cms_shop_items_cats";

                $result = $instanceDb->query($sql);

                if ($instanceDb->num_rows($result)) {
                    $maxNumberColumnOrdering = $instanceDb->fetch_assoc($result);
                }

                $thisItem['item_id'] = $lastIdInTable;
                $thisItem['category_id'] = 10991;
                $thisItem['ordering'] = $maxNumberColumnOrdering['MAX(ordering)'] + 1;

                $instanceDb->insert('cms_shop_items_cats', $thisItem);

            } else {

                $sql = "SELECT old_price FROM cms_shop_items WHERE id = {$productId['id']}";

                $result = $instanceDb->query($sql);

                if ($instanceDb->num_rows($result)) {
                    $oldPrice = $instanceDb->fetch_row($result);
                }

                if (!(int)$oldPrice[0]) {
                    $item['price'] = (int)$items->Товар[$i]->Стоимость;
                    $item['qty'] = (int)$items->Товар[$i]->КоличествоОстаток;
                    $item['update_at'] = date('Y-m-d H:i:s');
                    $instanceDb->update('cms_shop_items', $item, $productId['id']);
                } else {
                    $item['qty'] = (int)$items->Товар[$i]->КоличествоОстаток;
                    $item['old_price'] = (int)$items->Товар[$i]->Стоимость;
                    $item['update_at'] = date('Y-m-d H:i:s');
                    $instanceDb->update('cms_shop_items', $item, $productId['id']);

                }

            }
        }
        
    }

}