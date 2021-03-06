<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://nimbl.es/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Log\Formatter;

require_once 'SimpleTest.php';
require_once 'FormatterTest.php';

use Nimbles\Core\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Log
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Core - Log - Formatter
     * @return \PHPUnit_Framework_TestSuite
     */
    public static function suite() {
        $suite = new \PHPUnit_Framework_TestSuite('Nimbles Framework - Core - Log - Formatter');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Log\Formatter\SimpleTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Log\Formatter\FormatterTest');
        return $suite;
    }
}
