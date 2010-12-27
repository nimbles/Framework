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
 * @package    Nimbles
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles;

/**
 * @category   Nimbles
 * @package    \Nimbles\Core\Delegates
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @group      Nimbles
 */
class NimblesTest extends \Nimbles\Core\TestCase {
    /**
     * Tests getting an instance of Nimbles
     * @return void
     */
    public function testGetInstance() {
        $this->assertInstanceOf('\Nimbles', \Nimbles::getInstance());
        \Nimbles::setInstance();
        $this->assertInstanceOf('\Nimbles', \Nimbles::getInstance());
    }
    
    /**
     * Tests that the environment vars are setup when creating a new Nimbles object
     * @return void
     */
    public function testSetupEnvVars() {
        if (!extension_loaded('runkit')) {
            $this->markTestSkipped('Runkit extension is needed for this test');
        }
        
        if (!defined('NIMBLES_PATH')) {
            $this->markTestSkipped('Previous NIMBLES_PATH value is needed');
        }
        
        if (!defined('NIMBLES_LIBRARY')) {
            $this->markTestSkipped('Previous NIMBLES_LIBRARY value is needed');
        }
        
        \Nimbles::setInstance();
        $path = NIMBLES_PATH;
        $lib = NIMBLES_LIBRARY;

        \runkit_constant_remove('NIMBLES_PATH');
        \runkit_constant_remove('NIMBLES_LIBRARY');
        
        $this->assertType('\Nimbles', \Nimbles::getInstance());
        
        $this->assertTrue(defined('NIMBLES_PATH'));
        $this->assertEquals($path, NIMBLES_PATH);
        
        $this->assertTrue(defined('NIMBLES_LIBRARY'));
        $this->assertEquals($lib, NIMBLES_LIBRARY);
    }
}