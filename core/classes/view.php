<?php

class View {
	
	public static function forge($view, $data = array()) {
		return new static($view, $data);
	}

	private $view = '';
	private $data = array();

	private function __construct($view, $data) {
		$filename = APPPATH . 'views/' . $view . '.php';
		if (!file_exists($filename)) {
			throw new GeneralException('View ' . $filename . ' does not exist');
		}
		$this->view = $filename;
		$this->data = $data;
	}

	public function set($key, $value = '') {
		if (is_array($key)) {
			foreach ($key as $k => $v) {
				$this->set($k, $v);
			}
			return;
		}
		$this->data[$key] = $value;
	}

	public function render() {
		foreach ($this->data as $key => $value) {
			$$key = $value;
		}
		ob_start();
		include $this->view;
		$content = ob_get_clean();
		return $content;
	}

	public function __toString() {
		return $this->render();
	}
}