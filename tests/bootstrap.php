<?php
define('LIB_PATH', realpath(dirname(__FILE__) . '/../src/'));

set_include_path(
	LIB_PATH . PATH_SEPARATOR .
	get_include_path()
);

require_once 'Mu.php';

new Mu();