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
 * @package    Mu-Core
 * @subpackage Loader
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Lib\Mu\Core;

use \Mu\Core\TestCase,
    Mu\Core\Loader;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Loader
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\TestCase
 *
 * @group      Mu
 * @group      Mu-Core
 * @group      Mu-Core-Loader
 */
class LoaderTest extends TestCase {
    /**
     * Tests that when registering that MU_PATH is made the first include path
     * @return void
     */
    public function testRegister() {
        $includepaths = explode(PATH_SEPARATOR, get_include_path());

        foreach ($includepaths as $index => $path) {
            if (MU_PATH === $path) {
                unset($includepaths[$index]);
                break;
            }
        }

        set_include_path(implode(PATH_SEPARATOR, $includepaths));
        $functions = spl_autoload_functions();
        if (is_array($functions) && ('Mu\Core\Loader' === $functions[0][0])) {
            spl_autoload_unregister('Mu\Core\Loader::autoload');
        }

        if (false === ($functions = spl_autoload_functions())) {
            $functions = array();
        }

        array_unshift($includepaths, MU_PATH);

        \Mu\Core\Loader::register();
        $this->assertSame($includepaths, explode(PATH_SEPARATOR, get_include_path()));
        $functions[] = array('Mu\Core\Loader', 'autoload');
        $this->assertSame($functions, spl_autoload_functions());
    }

    /**
     * Tests that a file exists
     * @return void
     */
    public function testFileExists() {
        $this->assertTrue(\Mu\Core\Loader::fileExists(__FILE__));
        $this->assertTrue(\Mu\Core\Loader::fileExists('Mu.php'));
        $this->assertFalse(\Mu\Core\Loader::fileExists(dirname(__FILE__) . PATH_SEPARATOR . 'Foo.php'));
    }

    /**
     * Tests autoloading classes
     * @return void
     */
    public function testAutoload() {
        \Mu\Core\Loader::autoload('Mu');
        $this->assertTrue(class_exists('Mu', false));

        $this->assertFalse(class_exists('Tests\Lib\Mu\Core\Loader\Mock', false));
        \Mu\Core\Loader::autoload('Tests\Lib\Mu\Core\Loader\Mock');
        $this->assertTrue(class_exists('Tests\Lib\Mu\Core\Loader\Mock', false));
    }
}