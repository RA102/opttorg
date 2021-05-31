<?php
/*******************************************************************************/
//                         InstantCMS v 1.10.6                                 //
//                      http://www.instantcmsv1.ru/                            //
//                       module "Universal Marquee"                            //
//                         written by Tokarev                                  //
//                                                                             //
//                       LICENSED BY GNU/GPL v2                                //
//                                                                             //
/*******************************************************************************/

function mod_sdecor($module_id, $cfg){ 

	$inCore = cmsCore::getInstance();
	$inDB   = cmsDatabase::getInstance();
	$inUser = cmsUser::getInstance();
	
    $inCore->loadModel('shop');
    $model = new cms_model_shop();	
	
	global $_LANG;

//	$tempArray = [];
//	foreach($cfg as $key => $item) {
//	    $tempArray[] = strrev($key);
//	    $tempArray[strrev($key)] = $item;
//    }
//
//	$bool = ksort($tempArray);



	$default_cfg = [
        'menuCategory0'    => '',
        'sd_tovar_0'   	   => '118685,120786',
        'sd_rubric_0'      => '1051,1058,1053,11042,11060',
        'sd_brand_0'       => '34,88,94,85,93,105,119,130,26,129,30,33,73,76,124,46,128,147',
        'menuCategory1'  => '',
        'sd_tovar_1'       => '125080,3178',
        'sd_rubric_1'      => '1047,1048,11020,1050,926,1049',
        'sd_brand_1'       => '34,144,29,116,94,24,26,23',
        'menuCategory2'    => '',
        'sd_tovar_2'       => '112520,120178',
        'sd_rubric_2'      => '11017,11018,11019,11006,1040,11009,1044,1042,10955',
        'sd_brand_2'       => '98,85,29,13,94,129,104,24,73,23,128',
		'menuCategory3'    => '',
		'sd_tovar_3'   	   => '125098,123566',
		'sd_rubric_3'      => '1063,1061,1062,1064,10963',
		'sd_brand_3'       => '29,143,94,83,86,19,128',
		'menuCategory4'    => '',
		'sd_tovar_4'   	   => '125010,125052',
		'sd_rubric_4'      => '1035,10510,11012,11014,11013,11015,11016,1037,11059,1036',
		'sd_brand_4'       => '29,144,94,122,38,120,73,141,109,123,11',
		'menuCategory5'    => '',
		'sd_tovar_5'   	   => '125121,125048',
		'sd_rubric_5'      => '1065,1067,1069,11035,10956,1066,11036,11041,11029,10954,11037,11049',
		'sd_brand_5'       => '29,73,94,144,30,128,147',
		'menuCategory6'    => '',
		'sd_tovar_6'   	   => '125056,120752',
		'sd_rubric_6'      => '1034,11026,11027,11028,1055,1029,1031,10952,1030,10953,1052,1054,1055',
		'sd_brand_6'       => '34,85,29,143,94,16,93,13,119,105,82,130,73,129,144,33,124,76,128,133',
		'menuCategory7'    => '',
		'sd_tovar_7'   	   => '123755,123762',
		'sd_rubric_7'      => '1045,1046,11034',
		'sd_brand_7'       => '143,11,142,24,73',
		'menuCategory8'    => '',
		'sd_tovar_8'   	   => '121870,123070',
		'sd_rubric_8'      => '1059,1060,10972',
		'sd_brand_8'       => '94,73,93,108,30,111',
		'menuCategory9'    => '',
		'sd_tovar_9'   	   => '124027,123522',
		'sd_rubric_9'      => '11023,11024,11025',
		'sd_brand_9'       => '63,62',
        'menuCategory10'   => '',
        'sd_tovar_10'      => '124019,122059',
		'sd_rubric_10'     => '11087,11088,10509,11089,11031,1032',
		'sd_brand_10'      => '93,119,73,124,128,143,16,13,105,129,76,94,103',
        'menuCategory11'   => '',
        'sd_tovar_11'      => '',
        'sd_rubric_11'     => '',
        'sd_brand_11'      => '',
	];
	
	$cfg = array_merge($default_cfg, $cfg);
//	$sd_banner       = $cfg['sd_banner'];
//	$sd_link         = $cfg['sd_link'];



    foreach ($cfg as $index => $item) {
        if(preg_match('/menuCategory\d+/', $index)) {
            $$index = $model->getCategory($cfg["$index"]);
        } elseif(preg_match('/sd_tovar_\d+/', $index)) {
            $$index = $model->getSdTovar($cfg["$index"]);
        } elseif(preg_match('/sd_rubric_\d+/', $index)) {
            $$index = $model->getSdRubric($cfg["$index"]);
        } elseif(preg_match('/sd_brand_\d+/', $index)) {
            static $counter=0;
            $menuCategory = "menuCategory" . $counter;
            $$index = $model->getSdBrand($cfg["$index"], $$menuCategory['seolink']);
            $counter++;
        }
    }

//    $menuCategory0   = $model->getCategory($cfg['menuCategory0']); //$cfg['sd_title_0'];
//    $sd_tovar_0      = $model->getSdTovar($cfg['sd_tovar_0']);
//    $sd_rubric_0     = $model->getSdRubric($cfg['sd_rubric_0']);
//    $sd_brand_0      = $model->getSdBrand($cfg['sd_brand_0'], $menuCategory0['seolink']);
//	$menuCategory1   = $model->getCategory($cfg['menuCategory1']);
//	$sd_tovar_1      = $model->getSdTovar($cfg['sd_tovar_1']);
//	$sd_rubric_1     = $model->getSdRubric($cfg['sd_rubric_1']);
//	$sd_brand_1      = $model->getSdBrand($cfg['sd_brand_1'], $menuCategory1['seolink']);
//    $menuCategory2   = $model->getCategory($cfg['menuCategory2']);
//	$sd_tovar_2      = $model->getSdTovar($cfg['sd_tovar_2']);
//	$sd_rubric_2     = $model->getSdRubric($cfg['sd_rubric_2']);
//	$sd_brand_2      = $model->getSdBrand($cfg['sd_brand_2'], $menuCategory2['seolink']);
//    $menuCategory3   = $model->getCategory($cfg['menuCategory3']);
//	$sd_tovar_3      = $model->getSdTovar($cfg['sd_tovar_3']);
//	$sd_rubric_3     = $model->getSdRubric($cfg['sd_rubric_3']);
//	$sd_brand_3      = $model->getSdBrand($cfg['sd_brand_3'], $menuCategory3['seolink']);
//    $menuCategory4   = $model->getCategory($cfg['menuCategory4']); //$cfg['sd_title_4'];
//	$sd_tovar_4      = $model->getSdTovar($cfg['sd_tovar_4']);
//	$sd_rubric_4     = $model->getSdRubric($cfg['sd_rubric_4']);
//	$sd_brand_4      = $model->getSdBrand($cfg['sd_brand_4'], $menuCategory4['seolink']);
//    $menuCategory5   = $model->getCategory($cfg['menuCategory5']); //$cfg['sd_title_5'];
//	$sd_tovar_5      = $model->getSdTovar($cfg['sd_tovar_5']);
//	$sd_rubric_5     = $model->getSdRubric($cfg['sd_rubric_5']);
//	$sd_brand_5      = $model->getSdBrand($cfg['sd_brand_5'], $menuCategory5['seolink']);
//    $menuCategory6   = $model->getCategory($cfg['menuCategory6']); //$cfg['sd_title_6'];
//	$sd_tovar_6      = $model->getSdTovar($cfg['sd_tovar_6']);
//	$sd_rubric_6     = $model->getSdRubric($cfg['sd_rubric_6']);
//	$sd_brand_6      = $model->getSdBrand($cfg['sd_brand_6'], $menuCategory6['seolink']);
//    $menuCategory7   = $model->getCategory($cfg['menuCategory7']); //$cfg['sd_title_7'];
//	$sd_tovar_7      = $model->getSdTovar($cfg['sd_tovar_7']);
//	$sd_rubric_7     = $model->getSdRubric($cfg['sd_rubric_7']);
//	$sd_brand_7      = $model->getSdBrand($cfg['sd_brand_7'], $menuCategory7['seolink']);
//    $menuCategory8   = $model->getCategory($cfg['menuCategory8']); //$cfg['sd_title_8'];
//	$sd_tovar_8      = $model->getSdTovar($cfg['sd_tovar_8']);
//	$sd_rubric_8     = $model->getSdRubric($cfg['sd_rubric_8']);
//	$sd_brand_8      = $model->getSdBrand($cfg['sd_brand_8'], $menuCategory8['seolink']);
//    $menuCategory9   = $model->getCategory($cfg['menuCategory9']); //$cfg['sd_title_9'];
//	$sd_tovar_9      = $model->getSdTovar($cfg['sd_tovar_9']);
//	$sd_rubric_9     = $model->getSdRubric($cfg['sd_rubric_9']);
//	$sd_brand_9      = $model->getSdBrand($cfg['sd_brand_9'], $menuCategory9['seolink']);
//    $menuCategory10  = $model->getCategory($cfg['menuCategory10']); //$cfg['sd_title_10'];
//	$sd_tovar_10     = $model->getSdTovar($cfg['sd_tovar_10']);
//	$sd_rubric_10    = $model->getSdRubric($cfg['sd_rubric_10']);
//	$sd_brand_10     = $model->getSdBrand($cfg['sd_brand_10'], $menuCategory10['seolink']);
//    $menuCategory11  = $model->getCategory($cfg['menuCategory11']); //$cfg['sd_title_11'];
//    $sd_tovar_11     = $model->getSdTovar($cfg['sd_tovar_11']);
//    $sd_rubric_11    = $model->getSdRubric($cfg['sd_rubric_11']);
//    $sd_brand_11     = $model->getSdBrand($cfg['sd_brand_11'], $menuCategory11['seolink']);


    cmsPage::initTemplate('modules', 'mod_sdecor')->
    assign('sd_tovar_0', $sd_tovar_0)->
    assign('sd_rubric_0', $sd_rubric_0)->
    assign('sd_brand_0', $sd_brand_0)->
    assign('menuCategory0', $menuCategory0)->
    assign('menuCategory1', $menuCategory1)->
    assign('sd_banner', $sd_banner)->
    assign('sd_link', $sd_link)->
    assign('sd_tovar_1', $sd_tovar_1)->
    assign('sd_rubric_1', $sd_rubric_1)->
    assign('sd_brand_1', $sd_brand_1)->
    assign('sd_tovar_2', $sd_tovar_2)->
    assign('menuCategory2', $menuCategory2)->
    assign('sd_rubric_2', $sd_rubric_2)->
    assign('sd_brand_2', $sd_brand_2)->
    assign('sd_tovar_3', $sd_tovar_3)->
    assign('menuCategory3', $menuCategory3)->
    assign('sd_rubric_3', $sd_rubric_3)->
    assign('sd_brand_3', $sd_brand_3)->
    assign('menuCategory4', $menuCategory4)->
    assign('sd_tovar_4', $sd_tovar_4)->
    assign('sd_rubric_4', $sd_rubric_4)->
    assign('sd_brand_4', $sd_brand_4)->
    assign('menuCategory5', $menuCategory5)->
    assign('sd_tovar_5', $sd_tovar_5)->
    assign('sd_rubric_5', $sd_rubric_5)->
    assign('sd_brand_5', $sd_brand_5)->
    assign('menuCategory6', $menuCategory6)->
    assign('sd_tovar_6', $sd_tovar_6)->
    assign('sd_rubric_6', $sd_rubric_6)->
    assign('sd_brand_6', $sd_brand_6)->
    assign('menuCategory7', $menuCategory7)->
    assign('sd_tovar_7', $sd_tovar_7)->
    assign('sd_rubric_7', $sd_rubric_7)->
    assign('sd_brand_7', $sd_brand_7)->
    assign('menuCategory8', $menuCategory8)->
    assign('sd_tovar_8', $sd_tovar_8)->
    assign('sd_rubric_8', $sd_rubric_8)->
    assign('sd_brand_8', $sd_brand_8)->
    assign('menuCategory9', $menuCategory9)->
    assign('sd_tovar_9', $sd_tovar_9)->
    assign('sd_rubric_9', $sd_rubric_9)->
    assign('sd_brand_9', $sd_brand_9)->
    assign('menuCategory10', $menuCategory10)->
    assign('sd_tovar_10', $sd_tovar_10)->
    assign('sd_rubric_10', $sd_rubric_10)->
    assign('sd_brand_10', $sd_brand_10)->
    assign('menuCategory11', $menuCategory11)->
    assign('sd_tovar_11', $sd_tovar_11)->
    assign('sd_rubric_11', $sd_rubric_11)->
    assign('sd_brand_11', $sd_brand_11)->
    assign('cfg', $cfg)->
    display('mod_sdecor.tpl');

	return true;
}

