<?php
	date_default_timezone_set('America/Sao_Paulo');
	define('URL', '/INF2A_2014/public_html/');
	define('CONTROLLERS', 'modules/controllers/');
	define('MODELS', 'modules/models/');
	define('VIEWS', 'modules/views/');
	define('PAGES', 'modules/pages/');
	define('CSS', 'css/');
	define('JS', 'js/');

	function __autoload($file){
		require_once MODELS.$file.'.class.php';
	}

	require_once 'sys/Controller.class.php';
	require_once 'Settings.class.php';
	$start = new Settings();
?>