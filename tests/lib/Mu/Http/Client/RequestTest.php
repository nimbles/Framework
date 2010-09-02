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
 * @package    Mu-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */
namespace Tests\Lib\Mu\Http\Client;

use Mu\Http\TestCase,
    Mu\Http\Client\Request;

/**
 * @category   Mu
 * @package    Mu-Http
 * @subpackage Client
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Http\TestCase
 * @uses       \Mu\Http\Client\Request
 *
 * @group      Mu
 * @group      Mu-Http
 * @group      Mu-Http-Client
 * @group      Mu-Http-Client-Request
 */
class RequestTest extends TestCase {

    /**
     * @dataProvider provideRequestUri
     */
    public function testRequestUri($value, $valid) {
        $request = new Request();
        if (!$valid) {
            $this->setExpectedException('Mu\Http\Client\Exception');
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
            $this->setExpectedException('\Mu\Http\Client\Request\Exception\InvalidMethod');
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