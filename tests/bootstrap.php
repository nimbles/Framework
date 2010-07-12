<?php
define('APPLICATION_ENV', 'test');

// surpress warnings if timezone has not been set on the system
date_default_timezone_set(@date_default_timezone_get());

require_once realpath(dirname(__FILE__) . '/../lib/Mu.php');
new Mu();