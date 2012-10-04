<?php


class Input {
	
	public static function post($field, $default = false) {
		return (isset($_POST[$field])) ? $_POST[$field] : $default;
	}
	
	public static function method() {
		return (isset($_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'])) ? $_SERVER['HTTP_X_HTTP_METHOD_OVERRIDE'] : $_SERVER['REQUEST_METHOD'];
	}

}

