<?php

namespace lib\Abstracts;

abstract class InitDefaults {

	public $default_settings = [];
	public $settings = [];

	public function __construct() {
		$this->defineActions();
	}

	abstract public function defineActions();
}