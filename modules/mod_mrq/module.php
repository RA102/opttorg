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

function mod_mrq($module_id, $cfg){ 

	$inCore = cmsCore::getInstance();
	$inDB   = cmsDatabase::getInstance();
	$inUser = cmsUser::getInstance();
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
		'mrqfeed'          => 'https://sanmarket.kz/rss/comments/all/feed.rss',
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
	
	cmsPage::initTemplate('modules', 'mod_mrq')-> 
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
	display('mod_mrq.tpl'); 

	return true;
}

