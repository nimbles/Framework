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
 * @category  Mu
 * @package   \Mu\Core\Config
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Config
 */

namespace Tests\Mu\Core\Config;

use Mu\Core\Config;


/**
 * @category  Mu
 * @package   \Mu\Core\Config
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @group     \Mu\Core\Config
 */
class FileTest extends \Mu\Core\TestCase {
    /**
     * Test reading a config file for level 1
     * @return void
     */
    public function testLoadConfigFileLevel1() {
        $file = new Config\File(dirname(__FILE__) . '/_files/config.php', 'level1');

        $config = $file->getConfig();
        $this->assertType('\Mu\Core\Config', $config);

        $this->assertEquals(1, $config->config->a);
        $this->assertEquals(4, $config->config->d->e);
        $this->assertEquals(null, $config->config->j);
    }

    /**
     * Tests reading a config file for level 2 extending level 1
     * @return void
     */
    public function testLoadConfigFileLevel2() {
        $file = new Config\File(dirname(__FILE__) . '/_files/config.php', 'level2');

        $config = $file->getConfig();
        $this->assertType('\Mu\Core\Config', $config);

        $this->assertEquals('one', $config->config->a);
        $this->assertEquals('four', $config->config->d->e);
        $this->assertEquals(null, $config->config->j);
    }

    /**
     * Tests reading a config file for level 3 extending level 2
     * @return void
     */
    public function testLoadConfigFileLevel3() {
        $file = new Config\File(dirname(__FILE__) . '/_files/config.php', 'level3');

        $config = $file->getConfig();
        $this->assertType('\Mu\Core\Config', $config);

        $this->assertEquals('one', $config->config->a);
        $this->assertEquals('four', $config->config->d->e);
        $this->assertEquals(8, $config->config->j);
    }
}
