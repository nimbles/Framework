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
 * @package    Mu-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\App\Controller\Helper;

require_once 'HelperMock.php';

use Mu\App\TestCase;

/**
 * @category   Mu
 * @package    Mu-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\App\TestCase
 *
 * @group      Mu
 * @group      Mu-App
 * @group      Mu-App-Controller
 */
class HelperTest extends TestCase {
    /**
     * Tests that the helper abstract extends plugin abstract
     * @return void
     */
    public function testAbstract() {
        $helper = new HelperMock();
        $this->assertType('Mu\App\Controller\Helper\HelperAbstract', $helper);
        $this->assertType('Mu\App\Controller\Plugin\PluginAbstract', $helper);
    }

    /**
     * Tests that a helper implements the __invoke method
     * @return void
     */
    public function testInvoke() {
        $helper = new HelperMock();

        $this->assertTrue(method_exists($helper, '__invoke'));
        $this->assertTrue(is_callable($helper));
    }
}