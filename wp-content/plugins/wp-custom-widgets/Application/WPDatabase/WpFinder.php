<?php

namespace Application\WPDatabase;

class WpFinder {

	public static $instance = NULL;
	public static $prefix = '';
	public static $where = array();
	public static $sql = '';

	public static function select($table = 'application_faculty', $cols = NULL) {
		self::$instance = new WpFinder();

		if ($cols) {
			self::$prefix = 'SELECT ' . $cols . ' FROM ' . $table;
		} else {
			self::$prefix = 'SELECT * FROM ' . $table;
		}

		return self::$instance;
	}

	public static function where($filter = NULL) {
		self::$where[0] = ' WHERE ' . $filter;
		return self::$instance;
	}

	public static function like($a, $b) {
		self::$where[] = trim($a . ' LIKE ' . $b);
		return self::$instance;
	}

	public static function and($a = NULL) {
		self::$where[] = trim('AND ' . $a);
		return self::$instance;
	}

	public static function or($a = NULL) {
		self::$where[] = trim('OR' . $a);
		return self::$instance;
	}

	public static function in(array $a) {
		self::$where[] = 'IN ( ' . implode(',', $a) . ' )';
		return self::$instance;
	}

	public static function not($a = NULL) {
		self::$where[] = trim('NOT ' . $a);
		return self::$instance;
	}

	public static function getSql() {
		self::$sql = self::$prefix . implode(' ', self::$where);

		return trim(self::$sql);
	}
}