<?php
require APPPATH . 'vendor/recaptchalib.php';

spl_autoload_register(function ($class) {
	$filename = 'classes' . DIRECTORY_SEPARATOR . strtolower(str_replace('_',  DIRECTORY_SEPARATOR, $class)) . '.php';
	if (file_exists(APPPATH . $filename)) {
		include(APPPATH . $filename);
	} elseif (file_exists(COREPATH . $filename)) {
		include(COREPATH . $filename);
	} else {
		throw new GeneralException('Can not find file ' . $filename);
	}
	if (!class_exists($class)) {
		throw new GeneralException('Class was found and included but still can not find the class ' . $class);
	}
	if (method_exists($class, '_init') && is_callable(array($class, '_init'))) {
		$class::_init();
	}
});