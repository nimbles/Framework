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

namespace Tests\Lib\Nimbles\Core\Log;

require_once 'LoggableMock.php';

use Nimbles\Core\TestCase,
    Nimbles\Core\Log;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Log
 */
class LoggableTest extends TestCase {
    /**
     * Tests the loggable mixin methods
     * @return void
     */
    public function testMixinMethods() {
        $instance = Log::getInstance();
        $writer = new Log\Writer\Mock(array(
            'formatter' => array(
                'simple' => array(
                    'format' => '%category% - %message%'
                )
            )
        ));
        $instance->writers->mock = $writer;

        $loggable = new LoggableMock();
        $loggable->log('Hello world');
        $loggable->log(new Log\Entry(array(
            'message' => 'Hello world',
            'category' => 'test'
        )));

        $entries = $writer->getEntries();
        $this->assertEquals('uncategorised - Hello world', $entries[0]);
        $this->assertEquals('test - Hello world', $entries[1]);
    }
}
