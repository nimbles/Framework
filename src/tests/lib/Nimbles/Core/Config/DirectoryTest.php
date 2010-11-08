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
 * @category  Nimbles
 * @package   \Nimbles\Core\Config
 * @copyright Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license   http://nimbl.es/license/mit MIT License
 * @group     \Nimbles\Core\Config
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
class DirectoryTest extends TestCase {
    /**
     * Tests reading a directory of config files for level 1
     * @return void
     */
    public function testLoadConfigFileLevel1() {
        $dir = new Config\Directory(dirname(__FILE__) . '/_files/', 'level1');

        $config = $dir->getConfig();
        $this->assertType('\Nimbles\Core\Config', $config);

        $this->assertEquals(1, $config->config->a);
        $this->assertEquals(4, $config->config->d->e);
        $this->assertEquals(null, $config->config->j);

        $this->assertEquals(1, $config->additional->a);
        $this->assertEquals(2, $config->additional->b);
        $this->assertEquals(null, $config->additional->c);
    }

    /**
     * Tests reading a directory of config files for level 2 extending level 1
     * @return void
     */
    public function testLoadConfigFileLevel2() {
        $dir = new Config\Directory(dirname(__FILE__) . '/_files/', 'level2');

        $config = $dir->getConfig();
        $this->assertType('\Nimbles\Core\Config', $config);

        $this->assertEquals('one', $config->config->a);
        $this->assertEquals('four', $config->config->d->e);
        $this->assertEquals(null, $config->config->j);

        $this->assertEquals('one', $config->additional->a);
        $this->assertEquals('two', $config->additional->b);
        $this->assertEquals(null, $config->additional->c);
    }

    /**
     * Tests reading a directory of config files for level 3 extending level 2
     * @return void
     */
    public function testLoadConfigFileLevel3() {
        $dir = new Config\Directory(dirname(__FILE__) . '/_files/', 'level3');

        $config = $dir->getConfig();
        $this->assertType('\Nimbles\Core\Config', $config);

        $this->assertEquals('one', $config->config->a);
        $this->assertEquals('four', $config->config->d->e);
        $this->assertEquals(8, $config->config->j);

        $this->assertEquals('one', $config->additional->a);
        $this->assertEquals('two', $config->additional->b);
        $this->assertEquals(3, $config->additional->c);
    }
}
