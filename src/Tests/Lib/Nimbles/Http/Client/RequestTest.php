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
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Tests\Lib\Nimbles\Http\Client;

use Nimbles\Http\TestCase,
    Nimbles\Http\Client\Request;

/**
 * @category   Nimbles
 * @package    Nimbles-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Http\TestCase
 * @uses       \Nimbles\Http\Client\Request
 *
 * @group      Nimbles
 * @group      Nimbles-Http
 * @group      Nimbles-Http-Client
 * @group      Nimbles-Http-Client-Request
 */
class RequestTest extends TestCase {

    /**
     * @dataProvider provideRequestUri
     */
    public function testRequestUri($value, $valid) {
        $request = new Request();
        if (!$valid) {
            $this->setExpectedException('Nimbles\Http\Client\Exception');
        }
        $request->setRequestUri($value);
        $this->assertEquals($value, $request->getRequestUri());
    }

    public function provideRequestUri() {
        return array(
            array('schema://host:port/path?query', true),
            array(true, false),
            array(1, false),
        );
    }

    /**
     * @dataProvider methodDataProvider
     */
    public function testMethod($method, $valid) {
        $request = new Request();

        $constraint = $this->equalTo($method);
        if (!$valid) {
            $this->setExpectedException('\Nimbles\Http\Client\Request\Exception\InvalidMethod');
            $constraint = $this->logicalNot(
                $this->equalTo($method)
            );
        }

        $returnValue = $request->setMethod($method);

        $this->assertThat($request->getMethod(), $constraint);
        $this->assertEquals($request, $returnValue);
    }

    public function methodDataProvider() {
        return array(
            array('GET', true),
            array('HEAD', true),
            array('POST', true),
            array('PUT', true),
            array('DELETE', true),
            array('OPTIONS', true),
            array('CLEAR', true),
            array('T35T', true),
            array('HTTP VERB', false),
            array('{[]}', false),
            array('', false),
            array(0, false),
            array(array(), false),
            array(new \stdClass(), false),
        );
    }
}