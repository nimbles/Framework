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
 * @package    Nimbles-Container
 * @subpackage ContainerTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Container;

use Nimbles\Container\TestCase,
    Nimbles\Container\Container,
    Nimbles\Container\Definition;

require_once 'ContainerMock.php';

/**
 * @category   Nimbles
 * @package    Nimbles-Container
 * @subpackage ContainerTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Container\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Container
 */
class ContainerTest extends TestCase {
    /**
     * Tests that the container extens a collection and has the correct default settings
     * @return void
     */
    public function testCollection() {
        $container = new Container();
        
        $this->assertType('Nimbles\Core\Collection', $container);
        
        $this->assertEquals('Nimbles\Container\Definition', $container->getType());
        $this->assertEquals(Container::INDEX_ASSOCITIVE, $container->getIndexType());
        $this->assertFalse($container->isReadOnly());
    }
    
    /**
     * Tests that when creating a container, the default options are retained
     * @return void
     */
    public function testCollectionOptions() {
        $container = new Container(null, array(
            'type' => 'string',
            'indexType' => Container::INDEX_NUMERIC,
            'readonly' => false
        ));
        
        $this->assertEquals('Nimbles\Container\Definition', $container->getType());
        $this->assertEquals(Container::INDEX_ASSOCITIVE, $container->getIndexType());
        $this->assertFalse($container->isReadOnly());
    }
}