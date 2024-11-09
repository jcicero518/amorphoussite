<?php
if (isset($_ENV['PANTHEON_ENVIRONMENT'])) {
	return [
		'driver'   => 'mysql',
		'dbname'   => $_ENV['DB_NAME'],
		'host'     => $_ENV['DB_HOST'] . ':' . $_ENV['DB_PORT'],
		'user'     => $_ENV['DB_USER'],
		'password' => $_ENV['DB_PASSWORD'],
		'errmode'  => PDO::ERRMODE_EXCEPTION
	];
} else if ($_SERVER['HTTP_HOST'] == 'wplive.sunycgcc.edu') {
	return [
		'driver'   => 'mysql',
		'dbname'   => 'wordpress-live',
		'host'     => 'localhost',
		'user'     => 'wordpressuser742',
		'password' => 'Nv4qtLzn2w6hujil',
		'errmode'  => PDO::ERRMODE_EXCEPTION
	];
} else {
	return [
		'driver'   => 'mysql',
		'dbname'   => 'amorphous',
		'host'     => 'localhost',
		'user'     => 'homestead',
		'password' => 'secret',
		'errmode'  => PDO::ERRMODE_EXCEPTION
	];
}