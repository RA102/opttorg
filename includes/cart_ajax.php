<?
session_start();    
 
define('PATH', $_SERVER['DOCUMENT_ROOT']);
define('HOST', 'http://' . $_SERVER['HTTP_HOST']);
define("VALID_CMS", 1);	
 
include(PATH.'/core/ajax/ajax_core.php');
include(PATH.'/includes/config.inc.php');
 
$inCore = cmsCore::getInstance();
$inDB = cmsDatabase::getInstance();
 
$inCore->loadModel('shop');
$model = new cms_model_shop();
 
 
//добавляем товар в корзину
$item_id=$inCore->request('id', 'int', 0);;
$var_art_no = '';
 
$qty  = 1;
$item = $inDB->get_fields('cms_shop_items','id='.$item_id, 'id, category_id');
 
$model->addToCart($item_id, $var_art_no, $qty, $chars);
 
 
$items = $model->getCartItems();
$totalsumm = 0;
foreach($items as $item){
   $qty = $item['cart_qty'];
   $totalsumm += ($item['price'] * $qty);
}
if (!$items) $items_count = 0;
else $items_count =  (int)sizeof($items);
$totalsumm = round($totalsumm, 2);
 
echo $_GET['callback'] . '{"items_count":"'.$items_count.'", "totalsumm":"'.$totalsumm.'"}';
?>