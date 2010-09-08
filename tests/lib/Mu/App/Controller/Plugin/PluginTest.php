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

namespace Tests\Lib\Mu\App\Controller\Plugin;

require_once 'PluginMock.php';
require_once dirname(__FILE__) . '/../ControllerMock.php'; // not sure why this has to be done

use Mu\App\TestCase,
    Tests\Lib\Mu\App\Controller\ControllerMock,
    Tests\Lib\Mu\App\Controller\RequestMock,
    Tests\Lib\Mu\App\Controller\ResponseMock;

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