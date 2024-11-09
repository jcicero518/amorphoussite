<?php
namespace lib\Autoload;

class Loader {

	const UNABLE_TO_LOAD = 1;
	public static $dirs;
	public static $registered = 0;

	public function __construct($dirs = array()) {
		self::init($dirs);
	}

	protected static function loadFile($file) {

		if (file_exists($file)) {
			require_once $file;
			return TRUE;
		}
		return FALSE;
	}

	public static function autoLoad($class) {
		$success = false;

		$fn = str_replace('\\', DIRECTORY_SEPARATOR, $class) . '.php';
		foreach (self::$dirs as $start) {
			$file = $start . DIRECTORY_SEPARATOR . $fn;
			if (self::loadFile($file)) {
				$success = true;
				break;
			}
		}

		if (!$success) {
			if (!self::loadFile(__DIR__ . DIRECTORY_SEPARATOR . $fn)) {
				// Don't throw an exception in case we bump into another autoloader
			}
		}
		return $success;
	}

	public static function addDirs($dirs) {

		if (is_array($dirs)) {
			self::$dirs = array_merge(self::$dirs, $dirs);
		} else {
			self::$dirs[] = $dirs;
		}
	}

	public static function init($dirs = array()) {

		if ($dirs) {
			self::addDirs($dirs);
		}

		if ( self::$registered == 0 ) {
			spl_autoload_register( __CLASS__ . '::autoload' );
			self::$registered++;
		}

	}

}