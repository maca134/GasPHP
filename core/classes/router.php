<?php

class Router {
	private static $_instance = null;

	public static function forge() {
		if (static::$_instance == null) {
			static::$_instance = new static;
		}
		return static::$_instance;
	}

	private $route = array();
	private $index_route = '';

	private function __construct () {
		$config = Config::get('route');
		$this->index_route = $config['index'];
	}

	public function execute() {
		// Get the requested URI
		$this->route = (isset($_SERVER['PATH_INFO']) && !empty($_SERVER['PATH_INFO'])) ? explode('/', ltrim($_SERVER['PATH_INFO'], '/')) : array($this->index_route);

		// Checks if the controller exists
		$controller_name = 'Controller_' . ucwords($this->route[0]);
		try {
			$controller = new $controller_name;
		} catch (GeneralException $e) {
			throw new HttpNotFoundException('Can not find controller ' . $controller_name);
		}

		// Checks the method exists
		$method = (isset($this->route[1])) ? 'action_' . $this->route[1] : 'action_index';
		if (!method_exists($controller, $method)) {
			throw new HttpNotFoundException('Can not find method ' . $controller_name . '::' . $method);
		}

		// Sorted the method params out
		$params = $this->route;
		unset($params[0], $params[1]);

		// Calls the method and checks the returned value is a Response object
		$response = call_user_func_array(array($controller, $method), $params);
		if (gettype($response) !== 'object' || get_class($response) !== 'Response') {
			throw new GeneralException('Controllers must return a response object');
		}

		// Renders reponse, sends headers...
		echo $response;
	}

}