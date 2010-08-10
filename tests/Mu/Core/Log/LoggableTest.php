<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  Mu
 * @package   \Mu\Core\Log
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Log
 */

namespace Tests\Mu\Core\Log;

require_once 'LoggableMock.php';

/**
 * @category  Mu
 * @package   \Mu\Core\Log
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Log
 */
class LoggableTest extends \Mu\Core\TestCase {
    /**
     * Tests the loggable mixin methods
     * @return void
     */
    public function testMixinMethods() {
        $instance = \Mu\Core\Log::getInstance();
        $writer = new \Mu\Core\Log\Writer\Mock(array(
            'formatter' => array(
                'simple' => array(
                    'format' => '%category% - %message%'
                )
            )
        ));
        $instance->writers->mock = $writer;

        $loggable = new LoggableMock();
        $loggable->log('Hello world');
        $loggable->log(new \Mu\Core\Log\Entry(array(
            'message' => 'Hello world',
            'category' => 'test'
        )));

        $entries = $writer->getEntries();
        $this->assertEquals('uncategorised - Hello world', $entries[0]);
        $this->assertEquals('test - Hello world', $entries[1]);
    }
}
