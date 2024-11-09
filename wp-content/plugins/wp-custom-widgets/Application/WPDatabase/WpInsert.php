<?php

namespace Application\WPDatabase;


class WpInsert {

	public static $wpdb;
	public static $sql = '';
	public static $instance = NULL;
	public static $prefix = '';
	public static $cols = '';
	public static $values = '';
	public static $prepareString = '';
	public static $prepareArgs = array();

	public static function prepare($table = 'application_faculty') {
		self::$instance = new WpInsert();

		self::$prefix = 'INSERT INTO ' . $table . ' ';
		return self::$instance;
	}

	/**
	 * Set static instance of Wordpress's global $wpdb DBAL
	 *
	 * @param object $wpdb
	 *
	 * @return null
	 */
	public static function setWpDbal($wpdb) {
		self::$wpdb = $wpdb;

		return self::$instance;
	}

	/**
	 * Prepare columns for insert
	 *
	 * @param mixed(string|array) $cols
	 *
	 * @return null
	 */
	public static function prepCols($cols = NULL) {
		if (is_array($cols)) {
			self::$cols = '(' . implode(',', $cols) . ') ';
		} else {
			self::$cols = '(' . $cols . ') ';
		}

		return self::$instance;
	}

	/**
	 * Set VALUES set of insert SQL statement
	 *
	 * @param mixed(string|array) $values
	 *
	 * @return self
	 */
	public static function prepValues($values = NULL) {
		if (is_array($values)) {
			$value_types = [];
			foreach ($values as $value) {

				switch ($value) {
					case '':
						array_push($value_types, '%s');
						break;
					case (gettype($value) === 'integer') :
						array_push($value_types, '%d');
						break;
					case (gettype($value) === 'string'):
						array_push($value_types, '%s');
						break;
					default:
						array_push($value_types, '%s');
				}
			}

			if (count($value_types)) {
				self::$values = 'VALUES (' . implode(',', $value_types) . ')';
			}
		} else {
			self::$values = 'VALUES (' . $values . ')';
		}

		return self::$instance;
	}

	/**
	 * Glue the SQL components together
	 *
	 * @return null
	 */
	public static function prepForQuery() {
		self::$sql = self::$prefix . self::$cols . self::$values;

		return self::$instance;
	}

	/**
	 * Return SQL string
	 *
	 * @return string
	 */
	public static function getPrepQuery() {
		return trim(self::$sql);
	}
}