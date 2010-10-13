<?php
define('APPLICATION_ENV', 'test');

PHPUnit_Util_Filter::addDirectoryToFilter(dirname(__FILE__));
PHPUnit_Util_Filter::addDirectoryToWhitelist(realpath(dirname(__FILE__) . '/../lib/'));

PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Nimbles/Core/TestCase.php'));
PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Nimbles/Core/TestSuite.php'));
PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Nimbles/Cli/TestCase.php'));
PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Nimbles/Cli/TestSuite.php'));
PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Nimbles/Http/TestCase.php'));
PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Nimbles/Http/TestSuite.php'));
PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Nimbles/App/TestCase.php'));
PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Nimbles/App/TestSuite.php'));

// surpress warnings if timezone has not been set on the system
date_default_timezone_set(@date_default_timezone_get());

require_once realpath(dirname(__FILE__) . '/../lib/Nimbles.php');
new Nimbles();
