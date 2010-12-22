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
 * @package    Nimbles-Service
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Service\Http;

use Nimbles\Service\TestCase,
    Nimbles\Service\Http\Header;

/**
 * @category   Nimbles
 * @package    Nimbles-Service
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Service\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Service
 * @group      Nimbles-Service-Http
 */
class HeaderTest extends TestCase {
    /**
     * Tests that a header object extends a Nimbles\Core\Collection
     * @return void
     */
    public function testAbstract() {
        $header = new Header();
        $this->assertType('Nimbles\Core\Collection', $header);
    }
    
    /**
     * Tests the default options are set
     * @return void
     */
    public function testConstruct() {
        $header = new Header();
        
        $this->assertEquals('string', $header->getType());
        $this->assertEquals(Header::INDEX_NUMERIC, $header->getIndexType());
        
        $header = new Header(null, array(
            'type' => 'int',
            'indexType' => Header::INDEX_MIXED
        ));
        
        $this->assertEquals('string', $header->getType());
        $this->assertEquals(Header::INDEX_NUMERIC, $header->getIndexType());
    }
    
    /**
     * Tests getting and setting the header name
     * @return void
     * 
     * @dataProvider nameProvider
     */
    public function testSetName($name, $expected, $valid = true) {
        $header = new Header(null, array('name' => 'x-foo'));
        $this->assertEquals('X-Foo', $header->getName());
        
        if (!$valid) {
            $this->setExpectedException('Nimbles\Service\Http\Header\Exception\InvalidName');
        }
        
        $header->setName($name);
        $this->assertEquals($expected, $header->getName());
    }
    
    /**
     * Tests that a header correctly converts to a string
     * @return void
     */
    public function testToString() {
        $header = new Header(array(
            '/uri'
        ), array(
            'name' => 'Location'
        ));
        
        $this->assertEquals('Location: /uri', (string) $header);
        
        $header[] = '/uri2';
        $this->assertEquals('Location: /uri, /uri2', (string) $header);
    }
    
    /**
     * Tests sending a header
     * @return void
     * @override header
     */
    public function testSend() {
        $header = new Header(array(
            '/uri'
        ), array(
            'name' => 'Location'
        ));
        
        $header->send();
        $this->assertHeaderEquals('Location', '/uri');
        
        static::sendHeaders();
        $this->setExpectedException('Nimbles\Service\Http\Header\Exception\HeadersAlreadySent');
        $header->send();
    }
    
    /**
     * Tests removing a header
     * @return void
     * @override header
     */
    public function testRemove() {
        $header = new Header(array(
            '/uri'
        ), array(
            'name' => 'Location'
        ));
        
        $header->send();
        $this->assertHeaderEquals('Location', '/uri');
        
        $header->remove();
        $this->assertHeaderNotExists('Location');
        
        $header->send();
        
        static::sendHeaders();
        $this->setExpectedException('Nimbles\Service\Http\Header\Exception\HeadersAlreadySent');
        $header->remove();
    }
    
    /**
     * Data provider for header names
     * @return void
     */
    public function nameProvider() {
        return array(
            array('etag', 'ETag'),
            array('te', 'TE'),
            array('www_authenticate', 'WWW-Authenticate'),
            array('x_forwarded_for', 'X-Forwarded-For'),
            array(null, null, false),
            array('', '', false)
        );
    }
}