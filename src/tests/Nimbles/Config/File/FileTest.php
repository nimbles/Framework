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
 * @package    Nimbles-Config
 * @subpackage Collection
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Config\File;

use Nimbles\Config\TestCase,
    Nimbles\Config\Config,
    Nimbles\Config\File\FileAbstract;

/**
 * @category   Nimbles
 * @package    Nimbles-Config
 * @subpackage Collection
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Config\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Config
 */
class FileTest extends TestCase {
    /**
     * Tests creating config from multiple file types
     * 
     * @param string $file
     * @param string|null $type
     * @return void
     * 
     * @dataProvider fileProvider
     */
    public function testFactory($file, $type = null) {
        $config = FileAbstract::factory($file, $type);
        
        $this->assertEquals(1, $config->a);
        $this->assertType('Nimbles\Config\Config', $config->b);
        $this->assertEquals(2, $config->b->c);
        $this->assertEquals(4, $config->d->e);
    }
    
    /**
     * Data provider for factory
     * @return array
     */
    public function fileProvider() {
        return array(
            array(realpath(dirname(__FILE__) . '/_files/data.php')),
            array(realpath(dirname(__FILE__) . '/_files/data.php'), FileAbstract::TYPE_PHP),
            array(realpath(dirname(__FILE__) . '/_files/data.inc')),
            array(realpath(dirname(__FILE__) . '/_files/data.inc'), FileAbstract::TYPE_PHP),
            array(realpath(dirname(__FILE__) . '/_files/data.json')),
            array(realpath(dirname(__FILE__) . '/_files/data.json'), FileAbstract::TYPE_JSON),
            array(realpath(dirname(__FILE__) . '/_files/data.js')),
            array(realpath(dirname(__FILE__) . '/_files/data.js'), FileAbstract::TYPE_JSON),
            array(realpath(dirname(__FILE__) . '/_files/data.yml')),
            array(realpath(dirname(__FILE__) . '/_files/data.yml'), FileAbstract::TYPE_YAML),
        );
    }
}