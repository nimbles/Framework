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

namespace Tests\Lib\Nimbles\App\Controller\Plugin;

require_once 'PluginMock.php';
require_once dirname(__FILE__) . '/../ControllerMock.php'; // not sure why this has to be done

use Nimbles\App\TestCase,
    Tests\Lib\Nimbles\App\Controller\ControllerMock,
    Tests\Lib\Nimbles\App\Controller\RequestMock,
    Tests\Lib\Nimbles\App\Controller\ResponseMock;

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
class PluginTest extends TestCase {
    /**
     * Tests that after updating the plugin the getController method returns the controller
     * @return void
     */
    public function testGetController() {
        $plugin = new PluginMock();

        $this->assertNull($plugin->getController());
        $controller = new ControllerMock(new RequestMock(), new ResponseMock());
        $plugin->update($controller);

        $this->assertSame($controller, $plugin->getController());
    }
}