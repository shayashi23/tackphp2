<?php
define('DS', DIRECTORY_SEPARATOR);
define('APP_ROOT', dirname(dirname(__FILE__)) . DS);
//define('URL_ROOT', dirname($_SERVER['SCRIPT_NAME']));
// んーこうしないとサブディレクトリに対応できないなー
define('URL_ROOT', "/tackphp");	
define('CONTROLLER_DIR',APP_ROOT . "controller" . DS);
define('MODEL_DIR',	APP_ROOT . "model" . DS);
define('VIEW_DIR',	APP_ROOT . "view" . DS);
define('LIB_DIR',	APP_ROOT . "mylib" . DS);
define('COMPOSER_DIR',	APP_ROOT . "vendor" . DS);
define('LAYOUT_DIR',	VIEW_DIR . "layout" . DS);
define('STAGE',		require_once(APP_ROOT . "stage.php"));

// composer
// require COMPOSER . 'autoload.php';

function classAutoload($class_name){
	$controller_file = CONTROLLER_DIR . $class_name . ".php";
	if(file_exists($controller_file)){
		require_once $controller_file;
		return ;
	}
	$model_file = MODEL_DIR . $class_name . ".php";
	if(file_exists($model_file)){
		require_once $model_file;
		return ;
	}
	$lib_file = LIB_DIR . $class_name . ".php";
	if(file_exists($lib_file)){
		require_once $lib_file;
		return ;
	}
}
spl_autoload_register('classAutoload');

require_once APP_ROOT . "config.php";
require_once APP_ROOT . "function.php";
require_once APP_ROOT . "database.php";
require_once APP_ROOT . "Bootstrap.php";

$Bootstrap = new Bootstrap();
$Bootstrap->dispatch();
