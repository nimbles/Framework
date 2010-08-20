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
 * @package    Mu
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu;

/**
 * @category   Mu
 * @package    \Mu\Core\Delegates
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @group      Mu
 */
class MuTest extends \Mu\Core\TestCase {
    /**
     * Tests getting an instance of Mu
     * @return void
     */
    public function testGetInstance() {
        $this->assertType('\Mu', \Mu::getInstance());
        \Mu::setInstance();
        $this->assertType('\Mu', \Mu::getInstance());
    }
}