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
 * @package    Nimbles-Multiton
 * @subpackage MultitonTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Pattern;

require_once 'MultitonMock.php';

use Nimbles\Core\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Multiton
 * @subpackage MultitonTest
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Adapter\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Multiton
 */
class MultitonTest extends TestCase {

    /**
     * Test the getInstance method
     */
    public function testMultiton() {
        $instanceBasic1 = BasicMultiton::getInstance();
        $this->assertEquals('', $instanceBasic1->getValue());

        $instanceBasic2 = BasicMultiton::getInstance();
        $this->assertEquals($instanceBasic1, $instanceBasic2);

        $instanceBasicFoo1 = BasicMultiton::getInstance('foo');
        $this->assertEquals('foo', $instanceBasicFoo1->getValue());

        $instanceBasicFoo2 = BasicMultiton::getInstance('foo');
        $this->assertEquals($instanceBasicFoo1, $instanceBasicFoo2);

        $this->assertNotEquals($instanceBasic1, $instanceBasicFoo2);
    }

}