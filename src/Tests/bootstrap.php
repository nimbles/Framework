<?php
define('APPLICATION_ENV', 'test');

define('TESTS_PATH', realpath(dirname(__FILE__) . '/'));

PHP_CodeCoverage_Filter::getInstance()->addDirectoryToWhitelist(TESTS_PATH . '/../Lib');

$dirs = scandir(TESTS_PATH . '/../Lib/Nimbles');
$testFiles = array();
foreach ($dirs as $dir) {
    if (false !== ($testcase = realpath(TESTS_PATH . '/../Lib/Nimbles/' . $dir . '/TestCase.php'))) {
        $testFiles[]= $testcase;
    }

    if (false !== ($testsuite = realpath(TESTS_PATH . '/../lib/Nimbles/' . $dir . '/TestSuite.php'))) {
        $testFiles[]= $testsuite;
    }
}

PHP_CodeCoverage_Filter::getInstance()->addFilesToBlacklist($testFiles);
PHP_CodeCoverage_Filter::getInstance()->addDirectoryToBlacklist(TESTS_PATH, array('.php', '.inc'));

// surpress warnings if timezone has not been set on the system
date_default_timezone_set(@date_default_timezone_get());

require_once realpath(TESTS_PATH . '/../Lib/Nimbles.php');
new Nimbles();

set_include_path(get_include_path() . PATH_SEPARATOR . realpath(TESTS_PATH . '/..'));