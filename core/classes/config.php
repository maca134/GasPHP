<?php

class Config {

	private static $_config = null;

	private static function load() {
		static::$_config = include(APPPATH . 'config.php');
	}

	public static function get($key, $default = null) {
		if (static::$_config == null) {
			static::load();
		}
		return (isset(static::$_config[$key])) ? static::$_config[$key] : $default;
	}

}