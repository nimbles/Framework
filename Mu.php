<?php
/**
 * @category Mu
 * @package Mu
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Mu {
	/**
	 * Class construct
	 * @return void
	 */
	public function __construct() {
		Mu\Loader::register();
	}
}