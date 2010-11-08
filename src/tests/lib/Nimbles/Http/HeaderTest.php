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
 * @package    Nimbles-Http
 * @subpackage Header
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Http;

use Nimbles\Http\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Header
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Http
 * @group      Nimbles-Http-Header
 */
class HeaderTest extends TestCase {
    /**
     * Tests the construct of a http header with no options
     * @return void
     */
    public function testConstruct() {
        $header = new \Nimbles\Http\Header();
        $this->assertType('\Nimbles\Core\Mixin\MixinAbstract', $header);
    }

    /**
     * Tests the construct of a http header with options
     * @return void
     */
    public function testConstructFromOptions() {
        $header = new \Nimbles\Http\Header(array(
            'name' => 'Content-Type',
            'value' => 'text/plain'
        ));

        $this->assertEquals('Content-Type', $header->getName());
        $this->assertEquals('text/plain', $header->getValue());

        $this->assertEquals('Content-Type: text/plain', (string) $header);
    }

    /**
     * Tests the header getter and setter
     * @return void
     */
    public function testNameGetterSetter() {
        $header = new \Nimbles\Http\Header();

        $this->assertNull($header->getName());

        $header->setName('Content-Type');
        $this->assertEquals('Content-Type', $header->getName());
        $this->assertEquals('Content-Type', (string) $header);
    }

    /**
     * Tests the header setter throwing exceptions
     * @return void
     */
    public function testSetInvalidName() {
        $this->setExpectedException('Nimbles\Http\Header\Exception\InvalidHeaderName');
        $header = new \Nimbles\Http\Header();

        $header->setName(true);
    }

    /**
     * Tests the getter and setter for a header
     */
    public function testValueGetterSetter() {
        $header = new \Nimbles\Http\Header(array(
            'name' => 'Accept'
        ));

        $this->assertNull($header->getValue());
        $this->assertEquals('Accept', (string) $header);

        $header->setValue('text/plain');
        $this->assertEquals('text/plain', $header->getValue());
        $this->assertEquals('Accept: text/plain', (string) $header);

        $header->setValue('text/xml', true);
        $this->assertType('array', $header->getValue());
        $this->assertContains('text/plain', $header->getValue());
        $this->assertContains('text/xml', $header->getValue());
        $this->assertEquals('Accept: text/plain, text/xml', (string) $header);

        $header->setValue('text/xml', false);
        $this->assertEquals('text/xml', $header->getValue());
        $this->assertEquals('Accept: text/xml', (string) $header);

        $header->setValue(null);
        $this->assertSame(null, $header->getValue());
    }

    /**
     * Tests the factory of headers
     * @dataProvider factoryProvider
     * @param string $name
     * @param string $string
     * @param string $expectedName
     * @param string $expectedValue
     * @param string $expectedValue
     * @return void
     */
    public function testFactory($name, $string, $expectedName, $expectedValue, $expectedToString) {
        $header = \Nimbles\Http\Header::factory($name, $string);

        $this->assertEquals($expectedName, $header->getName());
        $this->assertEquals($expectedValue, $header->getValue());
        $this->assertEquals($expectedToString, (string) $header);
    }

    /**
     * The data provider for headers
     * @return array
     */
    public function factoryProvider() {
        return array(
            array('accept-encoding', null, 'Accept-Encoding', null, 'Accept-Encoding'),
            array('accept-encoding', 'compress', 'Accept-Encoding', 'compress', 'Accept-Encoding: compress'),
            array('accept-encoding', 'compress, gz', 'Accept-Encoding', array('compress', 'gz'), 'Accept-Encoding: compress, gz')
        );
    }
}
