<?php
define('APPLICATION_ENV', 'test');

define('TESTS_PATH', realpath(dirname(__FILE__) . '/'));

//PHP_CodeCoverage_Filter::getInstance()->addDirectoryToWhitelist(TESTS_PATH . '/../Lib');

$useLowerCase = false;

if (is_dir(TESTS_PATH . '/../lib/nimbles')) {
    $useLowerCase = true;    
    define('NIMBLES_PATH', realpath(TESTS_PATH . '/../lib'));
    define('NIMBLES_LIBRARY', realpath(TESTS_PATH . '/../lib/nimbles'));
} else {
    define('NIMBLES_PATH', realpath(TESTS_PATH . '/../Lib'));
    define('NIMBLES_LIBRARY', realpath(TESTS_PATH . '/../Lib/Nimbles'));
}

$dirs = scandir(NIMBLES_LIBRARY);
$testFiles = array();
foreach ($dirs as $dir) {
    if (false !== ($testcase = realpath(NIMBLES_LIBRARY . $dir . ($useLowerCase ? '/testcase.php' : '/TestCase.php')))) {
        $testFiles[]= $testcase;
    }

    if (false !== ($testsuite = realpath(NIMBLES_LIBRARY . $dir . ($useLowerCase ? '/testsuite.php' : '/TestSuite.php')))) {
        $testFiles[]= $testsuite;
    }
}

PHP_CodeCoverage_Filter::getInstance()->addFilesToBlacklist($testFiles);
PHP_CodeCoverage_Filter::getInstance()->addDirectoryToBlacklist(TESTS_PATH, array('.php', '.inc'));

// surpress warnings if timezone has not been set on the system
date_default_timezone_set(@date_default_timezone_get());

if (file_exists(NIMBLES_PATH . '/nimbles.php')) {
    require_once realpath(NIMBLES_PATH . '/nimbles.php');
} else {
    require_once realpath(NIMBLES_PATH . '/Nimbles.php');
}
new Nimbles();

set_include_path(get_include_path() . PATH_SEPARATOR . realpath(TESTS_PATH . '/..'));