<?php

namespace Application\WPDatabase;

use Exception;

class Connection {

	public $wpdb;

	public function __construct(\wpdb $database) {
		try {
			$connected = $database->check_connection();

			if ($connected) {
				$this->wpdb = $database;
			}
		} catch(\Throwable $e) {
			echo $e->getMessage();
		}
	}

	public function prepare(string $sql, array $args) {
		return $this->wpdb->prepare($sql, $args);
	}

	public function query(string $sql) {
		try {
			$this->wpdb->query($sql);
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public function getResults(string $sql) {
		$result = false;

		try {
			$result = $this->wpdb->get_results($sql, ARRAY_A);
		} catch (Exception $e) {
			echo $e->getMessage();
		}

		return $result;
	}
}