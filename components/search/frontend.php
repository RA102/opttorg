<?php
/******************************************************************************/
//                                                                            //
//                           InstantCMS v1.10.6                               //
//                        http://www.instantcms.ru/                           //
//                                                                            //
//                   written by InstantCMS Team, 2007-2015                    //
//                produced by InstantSoft, (www.instantsoft.ru)               //
//                                                                            //
//                        LICENSED BY GNU/GPL v2                              //
//                                                                            //
/******************************************************************************/

if(!defined('VALID_CMS')) {
    die('ACCESS DENIED');
}

function search(){

    $inCore = cmsCore::getInstance();
    $inPage = cmsPage::getInstance();
    $inDB   = cmsDatabase::getInstance();

    global $_LANG;

    $model = cms_model_search::initModel();

    $do = $inCore->do;

    $pagetitle = $inCore->getComponentTitle();

	$inPage->setTitle($pagetitle);
    $inPage->addPathway($pagetitle, '/search');
	$inPage->addHead('<link rel="canonical" href="https://sanmarket.kz/search" />');
/* ==================================================================================================== */
/* ==================================================================================================== */
	if ($do == 'view'){
		if (mb_strlen($model->query)<=3 && mb_strlen($model->query)>=1){
			cmsCore::addSessionMessage($_LANG['ERROR'].': '.$_LANG['SHORT_QUERY'], 'error');
			$inCore->redirect('/search');
		}

		if($model->query){

			$inPage->addPathway($model->query);
			$inPage->addPathway($model->query);

			// если параметры запроса изменились
			// делаем полный поиск, заполняя кеш
			// иначе берем из кеша результаты
			if(!$model->isChangedParams()){

				// Удаляем записи поиска от текущей сессии
				$model->deleteResultsFromThisSession();

				// Готовим поиск
				// выполняется поиск по индексу фултекст
				if(!$model->prepareSearch()) {
				    cmsCore::error404();
				}

				// Кладем в сессию текущие параметры запроса
				cmsUser::sessionPut('query_params', $model->parametrs_array);
				// кладем в сессию слова запроса
				cmsUser::sessionPut('searchquery', $model->words);

			}

			// формируем условия выборки
			$model->whereSessionIs(session_id());
			$model->wherePeriodIs();
    		$inDB->orderBy('pubdate', ($model->order_by_date ? 'DESC' : 'ASC'));

			// Получаем общее количество результатов
			$total = $model->getCountResults();

			// Получаем сами результаты поиска
			if($total){
				$results = $model->getResults();
			}

		}

		cmsPage::initTemplate('components', 'com_search_text')->
                assign('query', $model->query)->
                assign('look', $model->look)->
                assign('order_by_date', $model->order_by_date)->
                assign('from_pubdate', $model->from_pubdate)->
                assign('results', $results)->
                assign('total', $total)->
                assign('enable_components', $model->getEnableComponentsWithSupportSearch())->
                assign('from_component', $model->from_component)->
                assign('external_link', str_replace('%q%', urlencode($model->query), $_LANG['FIND_EXTERNAL_URL']))->
                assign('host', HOST)->
                assign('pagebar', cmsPage::getPagebar($total, $model->page, $model->config['perpage'], 'javascript:paginator(%page%)'))->
                display('com_search_text.tpl');

	}


    if ($do == 'newview') {

        ob_start();
        include_once $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . 'templates' . DIRECTORY_SEPARATOR . 'basic_free' . DIRECTORY_SEPARATOR . 'newsearch.php';

        return true;
    }

/* ==================================================================================================== */
/* ==================================================================================================== */
	if ($do == 'tag') {

		if (mb_strlen($model->query)<=3 && mb_strlen($model->query)>=1) {
			cmsCore::addSessionMessage($_LANG['EMPTY_QUERY'], 'error');
			$inCore->redirect('/search');
		}

		$inPage->setTitle($_LANG['SEARCH_BY_TAG'].' "'.$model->query.'"');
		$inPage->addHead('<link rel="canonical" href="https://sanmarket.kz/search" />');	
		if($model->query){
			$inPage->addPathway($_LANG['SEARCH_BY_TAG'].' "'.$model->query.'"');
		}
		$inPage->initAutocomplete();

		$total   = $model->getCountTags();

		$results = $model->searchByTag();

		cmsPage::initTemplate('components', 'com_search_tag')->
                assign('query', $model->query)->
                assign('results', $results)->
                assign('total', $total)->
                assign('autocomplete_js', $inPage->getAutocompleteJS('tagsearch', 'query', false))->
                assign('external_link', '/index.php?view=search&query='.urlencode($model->query).'&look=allwords')->
                assign('pagebar', cmsPage::getPagebar($total, $model->page, $model->config['perpage'], '/search/tag/'.urlencode($model->query).'/page%page%.html'))->
                display('com_search_tag.tpl');

	}

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
