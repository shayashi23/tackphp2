<?php

class Controller{
	public $layout;
	public $controller_name;
	public $action_name;
	public $debug_list = array();
	protected $_set_list = array();

	protected $Model;
	public function __construct(){
		$this->layout	= LAYOUT_DIR . "default.tpl";
		$this->Model	= new Model();
	}
	public function before(){
	}
	public function after(){
	}
	protected function set($key, $val){
		$this->_set_list[$key]	= $val;
		JsonApi::set($key, $val);
	}
	protected function render($view=null){
		$this->beforeRender();
		if(!$view)	$view = $this->controller_name . DS . $this->action_name;
		$view_file = VIEW_DIR . $view . ".tpl";
		if(DEBUG_MODE){
			if(!file_exists($view_file))	throw new Exception("VIEW FILE NOT FOUND: " . $view_file);
		}
		foreach($this->_set_list as $key => $val){
			$$key	= $val;
		}
		require_once($this->layout);
	}
	protected function jsonRender(){
		exit(JsonApi::get());
	}
	protected function beforeRender(){
		if(DEBUG_MODE){
			foreach($this->_set_list as $key => $val){
				$this->debug_list[$key]	= $val;
			}
		}
	}
	protected function redirect($url){
		$url	= URL_ROOT . $url;
		header("Location: " . $url);
		exit;
	}
	protected function error($message=null){
		if(!$message)	$message	= "ERROR Called.";
		throw new Exception($message);
	}
	protected function begin(){
		return $this->Model->beginTransaction();
	}
	protected function commit(){
		return $this->Model->commit();
	}
	protected function rollback(){
		return $this->Model->rollback();
	}
}
