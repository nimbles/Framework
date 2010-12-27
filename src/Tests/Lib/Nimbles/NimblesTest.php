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
}