<?php


if(!defined('VALID_CMS')) { die('ACCESS DENIED'); }

function banners()
{

    $inCore = cmsCore::getInstance();

    $model = new cms_model_banners();

    $do = $inCore->do;
	$banner_id = cmsCore::request('id', 'int', 0);

//======================================================================================================================//

    if ($do=='view'){

        $banner = $model->getBanner($banner_id);
		if(!$banner || !$banner['published']) { cmsCore::error404(); }

        $model->clickBanner($banner_id);
        cmsCore::redirect($banner['link']);

    }

}
