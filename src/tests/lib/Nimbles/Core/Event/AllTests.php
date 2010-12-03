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
 * @package    Nimbles-Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Event;

require_once 'CollectionTest.php';
require_once 'EventsTest.php';

use Nimbles\Core\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Event\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Event
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Event
     * @return \PHPUnit_Framework_TestSuite
     */
    public static function suite() {
        $suite = new TestSuite('Nimbles Framework - Event');
        
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Event\CollectionTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Core\Event\EventsTest');
        
        return $suite;
    }
}
