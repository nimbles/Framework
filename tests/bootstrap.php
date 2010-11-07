<?php
define('APPLICATION_ENV', 'test');

PHP_CodeCoverage_Filter::getInstance()->addDirectoryToBlacklist(dirname(__FILE__));
PHP_CodeCoverage_Filter::getInstance()->addDirectoryToWhitelist(realpath(dirname(__FILE__) . '/../lib/'));

$dirs = scandir(realpath(dirname(__FILE__) . '/../lib/Nimbles'));
$testFiles = array();
foreach ($dirs as $dir) {
    if (false !== ($testcase = realpath(dirname(__FILE__) . '/../lib/Mu/' . $dir . '/TestCase.php'))) {
        $testFiles[]= $testcase;
    }

    if (false !== ($testsuite = realpath(dirname(__FILE__) . '/../lib/Mu/' . $dir . '/TestSuite.php'))) {
    	$testFiles[]= $testsuite;
    }
}

PHP_CodeCoverage_Filter::getInstance()->addFilesToBlacklist($testFiles);

// surpress warnings if timezone has not been set on the system
date_default_timezone_set(@date_default_timezone_get());

require_once realpath(dirname(__FILE__) . '/../lib/Nimbles.php');
new Nimbles();