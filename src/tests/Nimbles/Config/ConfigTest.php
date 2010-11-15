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
 * @package    Nimbles-Config
 * @subpackage Collection
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Config;

use Nimbles\Config\TestCase,
    Nimbles\Config\Config;

/**
 * @category   Nimbles
 * @package    Nimbles-Config
 * @subpackage Collection
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Config\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Config
 */
class ConfigTest extends TestCase {
    /**
     * Tests that the Config class extends the Nimbles\Core\Collection class
     * @return void
     */
    public function testAbstract() {
        $config = new Config();
        $this->assertType('Nimbles\Core\Collection', $config);
    }

    /**
     * Tests that the index type always remains associtive
     * @return void
     */
    public function testDefaultOptions() {
        $config = new Config();
        $this->assertEquals(Config::INDEX_ASSOCITIVE, $config->getIndexType());
        $this->assertTrue($config->isReadOnly());
        
        $config = new Config(null, array(
            'indexType' => Config::INDEX_NUMERIC,
            'readonly'  => false
        ));
        
        $this->assertEquals(Config::INDEX_ASSOCITIVE, $config->getIndexType());
        $this->assertFalse($config->isReadOnly());
    }
    
    /**
     * Tests that creating a config object from a construct
     * @return void
     */
    public function testConstruct() {
        $data = array(
            'a' => 1,
            'b' => array(
                'c' => 2
            ),
            'd' => new Config(array('e' => 4))
        );
        
        $config = new Config($data);
        
        $this->assertEquals(1, $config->a);
        $this->assertType('Nimbles\Config\Config', $config->b);
        $this->assertEquals(2, $config->b->c);
        $this->assertEquals(4, $config->d->e);
        
        $this->setExpectedException('Nimbles\Core\Collection\Exception\ReadOnly');
        $config->f = 'foo';
    }
}