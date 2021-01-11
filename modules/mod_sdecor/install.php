<?php
  	function info_module_mod_sdecor(){
		$_module['title']        = 'Модуль в меню';
		$_module['name']         = 'Модуль в меню';
		$_module['description']  = 'Инфо для выпадающего меню';
		$_module['link']         = 'mod_sdecor';
		$_module['position']     = 'top';
		$_module['author']       = 'tokarev';
		$_module['version']      = '1.0';
		$_module['config'] = array();
		return $_module;
	}
	function install_module_mod_sdecor(){
		return true;
	}
	function upgrade_module_mod_sdecor(){
		return true;
	}
