<?php
  	function info_module_mod_mrq(){
		$_module['title']        = 'Universal Marquee';
		$_module['name']         = 'Universal Marquee';
		$_module['description']  = 'Универсальная бегущая строка';
		$_module['link']         = 'mod_mrq';
		$_module['position']     = 'top';
		$_module['author']       = 'tokarev';
		$_module['version']      = '1.0';
		$_module['config'] = array();
		return $_module;
	}
	function install_module_mod_mrq(){
		return true;
	}
	function upgrade_module_mod_mrq(){
		return true;
	}
?>