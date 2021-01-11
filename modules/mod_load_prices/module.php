<?php

/**
 * Модуль подгрузки инфо товарав из файла поставщика
 */

if(!defined('VALID_CMS')) {
    die('ACCESS DENIED');
}

function mod_load_prices($module_id, $cfg)
{
    $core = cmsCore::getInstance();
    $db = cmsDatabase::getInstance();
    $page = cmsPage::getInstance();

    global $_LANG;

    $default_cfg = array (
        'mrqid'      	   => 1,
        'mrqwidth'    	   => '100%',
        'mrqsize'    	   => 'bn-usual',
        'mrqmargin'   	   => 'mrqmgb0',
        'mrqmodul'   	   => 'breakingnews',
        'mrqcolor'         => 'light',
        'mrqborder'        => 'false',
        'mrqeffect'        => 'fade',
        'mrqfontstyle'     => 'normal',
        'mrqautoplay'      => 'false',
        'mrqtimer'         => 3000,
        'mrqfeedlabels'    => 'Новости',
        'mrqfeedcount'     => 3
    );

    $cfg = array_merge($default_cfg, $cfg);
    $mrqid           = $cfg['mrqid'];
    $mrqwidth        = $cfg['mrqwidth'];
    $mrqsize         = $cfg['mrqsize'];
    $mrqmargin       = $cfg['mrqmargin'];
    $mrqmodul        = $cfg['mrqmodul'];
    $mrqcolor        = $cfg['mrqcolor'];
    $mrqborder       = $cfg['mrqborder'];
    $mrqeffect       = $cfg['mrqeffect'];
    $mrqfontstyle    = $cfg['mrqfontstyle'];
    $mrqautoplay     = $cfg['mrqautoplay'];
    $mrqtimer        = $cfg['mrqtimer'];
    $mrqfeed         = $cfg['mrqfeed'];
    $mrqfeedlabels   = $cfg['mrqfeedlabels'];
    $mrqfeedcount    = $cfg['mrqfeedcount'];

    cmsPage::initTemplate('modules', 'mod_load_prices')->
    assign('mrqid', $mrqid)->
    assign('mrqwidth', $mrqwidth)->
    assign('mrqsize', $mrqsize)->
    assign('mrqmargin', $mrqmargin)->
    assign('mrqmodul', $mrqmodul)->
    assign('mrqcolor', $mrqcolor)->
    assign('mrqborder', $mrqborder)->
    assign('mrqeffect', $mrqeffect)->
    assign('mrqfontstyle', $mrqfontstyle)->
    assign('mrqautoplay', $mrqautoplay)->
    assign('mrqtimer', $mrqtimer)->
    assign('mrqfeed', $mrqfeed)->
    assign('mrqfeedlabels', $mrqfeedlabels)->
    assign('mrqfeedcount', $mrqfeedcount)->
    assign('cfg', $cfg)->
    display('mod_load_prices.tpl');

    return true;


}
