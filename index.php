<?php
error_reporting(E_ALL);

define('DOCROOT', __DIR__.DIRECTORY_SEPARATOR);
define('COREPATH', realpath(__DIR__.'/core/').DIRECTORY_SEPARATOR);
define('APPPATH', realpath(__DIR__.'/app/').DIRECTORY_SEPARATOR);
define('BASEURL', str_replace('index.php', '', $_SERVER['SCRIPT_NAME']));

class GeneralException extends Exception {}
class HttpNotFoundException extends Exception {}

require COREPATH .'bootstrap.php';

try {
	Router::forge()->execute();
} catch (HttpNotFoundException $e) {
	// Errors can be displayed in a more pleasing format...
	die($e->getMessage());
} catch (GeneralException $e) {
	die($e->getMessage());
}