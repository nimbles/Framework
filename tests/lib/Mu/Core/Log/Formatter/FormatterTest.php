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
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core\Log\Formatter;

use Mu\Core\TestCase;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Log
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestSuite
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Log
 */
class FormatterTest extends TestCase {
    /**
     * Tests that the \Mu\Core\Log\Formatter\Exception\InvalidOptions exception is thrown
     * when passing invalid options into the formatter factory
     * @dataProvider invalidOptionsProvider
     * @param mixed $options
     * @return void
     */
    public function testInvalidOptionsFactory($options) {
        $this->setExpectedException('\Mu\Core\Log\Formatter\Exception\InvalidOptions');
        \Mu\Core\Log\Formatter\FormatterAbstract::factory($options);
    }

    /**
     * Tests creating a formatter from valid options
     * @dataProvider validOptionsProvider
     * @param string|array $options
     * @return void
     */
    public function testValidOptionsFactory($options) {
        $formatter = \Mu\Core\Log\Formatter\FormatterAbstract::factory($options);
        $this->assertType('\Mu\Core\Log\Formatter\Simple', $formatter);
    }

    /**
     * Data provider for invalid factory options
     * @retun array
     */
    public function invalidOptionsProvider() {
        return array(
            array(array()),
            array(1),
            array(new \stdClass()),
            array(null)
        );
    }

    /**
     * Data provider for valid options
     * @return array
     */
    public function validOptionsProvider() {
        return array(
            array('simple'),
            array(array('simple' => array())),
            array(new \ArrayObject(
                array('simple' => array())
            )),
        );
    }
}