<?php
if ( !defined(ABSPATH) ) {
	define('ABSPATH', dirname(__FILE__) . '/');
}
define('DB_CONFIG_FILE', ABSPATH . '/data/config/db.config.php');

require __DIR__ . '/lib/Autoload/Loader.php';
lib\Autoload\Loader::init(__DIR__);