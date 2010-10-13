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

use Nimbles\Core\TestCase;

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
class FormatterTest extends TestCase {
    /**
     * Tests that the \Nimbles\Core\Log\Formatter\Exception\InvalidOptions exception is thrown
     * when passing invalid options into the formatter factory
     * @dataProvider invalidOptionsProvider
     * @param mixed $options
     * @return void
     */
    public function testInvalidOptionsFactory($options) {
        $this->setExpectedException('\Nimbles\Core\Log\Formatter\Exception\InvalidOptions');
        \Nimbles\Core\Log\Formatter\FormatterAbstract::factory($options);
    }

    /**
     * Tests creating a formatter from valid options
     * @dataProvider validOptionsProvider
     * @param string|array $options
     * @return void
     */
    public function testValidOptionsFactory($options) {
        $formatter = \Nimbles\Core\Log\Formatter\FormatterAbstract::factory($options);
        $this->assertType('\Nimbles\Core\Log\Formatter\Simple', $formatter);
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
