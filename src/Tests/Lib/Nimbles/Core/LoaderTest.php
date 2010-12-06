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
 * @subpackage Loader
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core;

use \Nimbles\Core\TestCase,
    Nimbles\Core\Loader;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Loader
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 * @group      Nimbles-Core-Loader
 */
class LoaderTest extends TestCase {
    /**
     * Tests that when registering that NIMBLES_PATH is made the first include path
     * @return void
     */
    public function testRegister() {
        $includepaths = explode(PATH_SEPARATOR, get_include_path());

        foreach ($includepaths as $index => $path) {
            if (NIMBLES_PATH === $path) {
                unset($includepaths[$index]);
                break;
            }
        }

        set_include_path(implode(PATH_SEPARATOR, $includepaths));
        $functions = spl_autoload_functions();
        if (is_array($functions) && ('Nimbles\Core\Loader' === $functions[0][0])) {
            spl_autoload_unregister('Nimbles\Core\Loader::autoload');
        }

        if (false === ($functions = spl_autoload_functions())) {
            $functions = array();
        }

        array_unshift($includepaths, NIMBLES_PATH);

        \Nimbles\Core\Loader::register();
        $this->assertSame($includepaths, explode(PATH_SEPARATOR, get_include_path()));
        $autoload = array('Nimbles\Core\Loader', 'autoload');
        $registered = array_reverse(spl_autoload_functions());
        
        $this->assertContains($autoload, $registered);
    }

    /**
     * Tests that a file exists
     * @return void
     */
    public function testFileExists() {
        $this->assertTrue(\Nimbles\Core\Loader::fileExists(__FILE__));
        $this->assertTrue(\Nimbles\Core\Loader::fileExists('Nimbles.php'));
        $this->assertFalse(\Nimbles\Core\Loader::fileExists(dirname(__FILE__) . PATH_SEPARATOR . 'Foo.php'));
    }

    /**
     * Tests autoloading classes
     * @return void
     */
    public function testAutoload() {        
        \Nimbles\Core\Loader::autoload('Nimbles');
        $this->assertTrue(class_exists('Nimbles', false));
        
        $includePath = get_include_path();
        
        set_include_path(
            $includePath . PATH_SEPARATOR .
            realpath(dirname(__FILE__) . '/../../') 
        );

        $this->assertFalse(class_exists('Nimbles\Core\Loader\Mock', false));
        $this->assertTrue(\Nimbles\Core\Loader::autoload('Nimbles\Core\Loader\Mock'), 'Failed to locate file for Mock');
        $this->assertTrue(class_exists('Nimbles\Core\Loader\Mock'), 'Mock class does not exist');
        
        set_include_path($includePath);
    }
}
