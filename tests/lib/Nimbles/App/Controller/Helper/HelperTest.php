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
 * @package    Nimbles-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\App\Controller\Helper;

require_once 'HelperMock.php';

use Nimbles\App\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Controller
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\App\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-App
 * @group      Nimbles-App-Controller
 */
class HelperTest extends TestCase {
    /**
     * Tests that the helper abstract extends plugin abstract
     * @return void
     */
    public function testAbstract() {
        $helper = new HelperMock();
        $this->assertType('Nimbles\App\Controller\Helper\HelperAbstract', $helper);
        $this->assertType('Nimbles\App\Controller\Plugin\PluginAbstract', $helper);
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