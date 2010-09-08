<?php
define('APPLICATION_ENV', 'test');

PHPUnit_Util_Filter::addDirectoryToFilter(dirname(__FILE__));
PHPUnit_Util_Filter::addDirectoryToWhitelist(realpath(dirname(__FILE__) . '/../lib/'));

PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Mu/Core/TestCase.php'));
PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Mu/Core/TestSuite.php'));
PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Mu/Cli/TestCase.php'));
PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Mu/Cli/TestSuite.php'));
PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Mu/Http/TestCase.php'));
PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Mu/Http/TestSuite.php'));
PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Mu/App/TestCase.php'));
PHPUnit_Util_Filter::addFileToFilter(realpath(dirname(__FILE__) . '/../lib/Mu/App/TestSuite.php'));

// surpress warnings if timezone has not been set on the system
date_default_timezone_set(@date_default_timezone_get());

require_once realpath(dirname(__FILE__) . '/../lib/Mu.php');
new Mu();
