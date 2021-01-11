<?php
  	function info_module_mod_sdvit(){
		$_module['title']        = 'Модуль в витрину';
		$_module['name']         = 'Модуль в витрину';
		$_module['description']  = 'Товары на витринке';
		$_module['link']         = 'mod_sdvit';
		$_module['position']     = 'mainbottom';
		$_module['author']       = 'tokarev';
		$_module['version']      = '1.0';
		$_module['config'] = array();
		return $_module;
	}
	function install_module_mod_sdvit(){
		return true;
	}
	function upgrade_module_mod_sdvit(){
		return true;
	}
