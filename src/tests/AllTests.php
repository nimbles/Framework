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

namespace Tests\lib\Nimbles\Event;

require_once 'CollectionTest.php';
require_once 'EventsTest.php';

use Nimbles\Event\TestSuite;

/**
 * @category   Nimbles
 * @package    Nimbles-Event
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestSuite
 *
 * @group      Nimbles
 * @group      Nimbles-Event
 */
class AllTests extends TestSuite {
    /**
     * Creates the Test Suite for Nimbles Framework - Event
     * @return \PHPUnit_Framework_TestSuite
     */
    static public function suite() {
        $suite = new TestSuite('Nimbles Framework - Event');
        
        $suite->addTestSuite('\Tests\Lib\Nimbles\Event\CollectionTest');
        $suite->addTestSuite('\Tests\Lib\Nimbles\Event\EventsTest');
        
        return $suite;
    }
}
