<?php

if(!defined('VALID_CMS')) {
    die('ACCESS DENIED');
}

function sphinx()
{

    $inCore = cmsCore::getInstance();
    $inPage = cmsPage::getInstance();
    $inDB   = cmsDatabase::getInstance();

    global $_LANG;

    $model = cms_model_search::initModel();

    $do = $inCore->do;

    if ($do == 'words') {
        $request = $inCore::request('value');
        $value = $request;

        $response = [];

        // Поиск по 1с артиклу и коду производителя
        $queryForArticleNumber = "SELECT i.ven_code, i.seolink, i.title, i.art_no 
                                  FROM cms_shop_items as i 
                                  WHERE ((LOWER(i.ven_code) LIKE '%$value%' OR i.art_no LIKE '%$value%') 
                                  AND i.published <> 0 
                                  AND i.category_id <> 10991) LIMIT 20 ";

        $mysqliResult = $inDB->query($queryForArticleNumber);

        if($inDB->num_rows($mysqliResult)) {
            while($item = $inDB->fetch_assoc($mysqliResult)) {
                $response['ven_code'][] = $item;
            }
        }

        // поиск по категории
        $queryForCategories = "SELECT c.title, c.seolink 
                               FROM cms_shop_cats as c 
                               WHERE (c.published <> 0 
                               AND c.title LIKE '%$value%')";

        $mysqliResult = $inDB->query($queryForCategories);

        if($inDB->num_rows($mysqliResult)) {
            while($item = $inDB->fetch_assoc($mysqliResult)) {
                $response['categories'][] = $item;
            }
        }

        // поиск по производителям
        $queryForVendors = "SELECT v.title, v.id 
                            FROM cms_shop_vendors as v 
                            WHERE (v.published <> 0 
                            AND v.title LIKE '%$value%')";

        $mysqliResult = $inDB->query($queryForVendors);

        if ($inDB->num_rows($mysqliResult)) {
            while($item = $inDB->fetch_assoc($mysqliResult)) {
                $response['vendors'][] = $item;
            }
        }

        // поиск по названию товара

        $queryForProducts = "SELECT i.title, i.seolink 
                                    FROM cms_shop_items as i 
                                    WHERE (i.title LIKE '%$value%' 
                                    AND i.published != 0)
                                    AND i.qty > 1 OR i.qty_from_vendor > 1 
                                    AND i.category_id != 10991 LIMIT 30";

        $mysqliResult = $inDB->query($queryForProducts);

        if ($inDB->num_rows($mysqliResult)) {
            while($item = $inDB->fetch_assoc($mysqliResult)) {
                $response['prod'][] = $item;
            }
        }

        (cmsPage::getInstance())->setRequestIsAjax();

//        die(json_encode($response));

        cmsCore::jsonOutput($response);
    }

    return true;

}