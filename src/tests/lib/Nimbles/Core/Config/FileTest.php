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
 * @package    Nimbles-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core\Config;

use Nimbles\Core\TestCase,
    Nimbles\Core\Config;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Config
 */
class FileTest extends TestCase {
    /**
     * Test reading a config file for level 1
     * @return void
     */
    public function testLoadConfigFileLevel1() {
        $file = new Config\File(dirname(__FILE__) . '/_files/config.php', 'level1');

        $config = $file->getConfig();
        $this->assertType('\Nimbles\Core\Config', $config);

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
        $this->assertType('\Nimbles\Core\Config', $config);

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
        $this->assertType('\Nimbles\Core\Config', $config);

        $this->assertEquals('one', $config->config->a);
        $this->assertEquals('four', $config->config->d->e);
        $this->assertEquals(8, $config->config->j);
    }
}
