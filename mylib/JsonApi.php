<?php
class JsonApi{
	protected static $list = array();
	public static function get(){
		return json_encode(self::$list);
	}
	public static function set($key, $val){
		self::$list[$key]	= $val;
	}
}
