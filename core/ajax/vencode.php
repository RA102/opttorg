<?php
define('PATH', $_SERVER['DOCUMENT_ROOT']);
include (PATH . '/core/ajax/ajax_core.php');

cmsCore::loadLanguage('components/shop');

$opt = cmsCore::request('opt', 'str', '');
$data = cmsCore::request('data', 'str', '');

if($opt == 'check_ven_code') {

    if(!$data) {
        cmsCore::halt();
    }

    if($data == '') {
        cmsCore::halt('<span style="color:red">'.  $_LANG['ERR_VENCODE'] .'</span>');
    }

    $sql = "SELECT id FROM cms_shop_items WHERE ven_code ='" . trim($data) . "'";
    $inDb = cmsDatabase::getInstance();
    $result = $inDb->query($sql);

    if($inDb->num_rows($result) == 0) {
        echo cmsCore::halt('<span id="span-error" class="green-text">' . $_LANG['NOT_EXIST_VENCODE']. '</span>');
    } else {
        echo cmsCore::halt('<span id="span-error" class="red-text">' . $_LANG['EXISTS_VENCODE'] . '</span>');
    }

}

cmsCore::halt();
