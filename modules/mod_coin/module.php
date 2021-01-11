<?php
function mod_coin($module_id, $cfg){ 

    $inCore = cmsCore::getInstance();
    $inDB   = cmsDatabase::getInstance();
	$inActions = cmsActions::getInstance();
	$inUser = cmsUser::getInstance();
	global $_LANG;  
		
	if (isset($_POST['secretid'])) {
		$inDB->query("INSERT INTO `cms_coins`(`secretid`, `userid`, `coin`) VALUES ('{$_POST['secretid']}','{$_POST['userid']}','{$_POST['coin']}')");
		
		cmsCore::addSessionMessage('Поздравляем! Вы получили скидку '.$_POST['coin'].'% на ближайший заказ!', 'success');
	}
	
	$userid = $inUser->id;
	
	$has_coin = $inDB->rows_count('cms_coins', "userid='{$userid}'");
	
	if (($has_coin == 0) || ($userid == 0)) {
	
		// рандомайзер
		
		$ver = rand(1,100);
		
		if (($ver > $cfg['coin1']) && ($ver <= $cfg['coin2'])) {
			$coin = 3;
		} elseif (($ver > $cfg['coin2']) && ($ver <= $cfg['coin3'])) {
			$coin = 5;
		} elseif (($ver > $cfg['coin3']) && ($ver <= $cfg['coin4'])) {
			$coin = 7;
		} elseif (($ver > $cfg['coin4']) && ($ver <= 100)) {	
			$coin = 10;
		} else {
			$coin = 0;
		}
		
		$top = rand(5,95);
		$left = rand(5,95);
		
		$secretid = time();
	
	} else {
		
		$coin = 0;
		
	}
	
	
	cmsPage::initTemplate('modules', 'mod_coin')-> 
	assign('ver', $ver)-> 
	assign('coin', $coin)-> 
	assign('top', $top)-> 
	assign('left', $left)-> 
	assign('secretid', $secretid)->
	assign('userid', $userid)->
	assign('cfg', $cfg)-> 
	display('mod_coin.tpl'); 

	return true;
}

