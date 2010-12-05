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
 * @subpackage Options
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Tests\Lib\Nimbles\Core;

require_once 'OptionsMock.php';

use Nimbles\Core\TestCase;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Optons
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\TestCase
 * @trait      \Tests\Lib\Nimbles\Core\Options
 *
 * @group      Nimbles
 * @group      Nimbles-Core
 */
class OptionsTest extends TestCase {
    /**
     * Data provider for options instance
     * @return array
     */
    public function optionsInstanceProvider() {
        return array(
            array(new OptionsMock())
        );
    }
    
    /**
     * Data provider for getting and setting an option on a given instance
     * @return void
     */
    public function getSetOptionProvider() {
        return array(
            array(new OptionsMock(), 'bool', true),
            array(new OptionsMock(), 'value', 123),
            array(new OptionsMock(array('bool' => false)), 'bool', true, false),
            array(new OptionsMock(array('foo' => 123)), 'foo', 'bar', 123),
        );
    }
    
    /**
     * Data provider for getting and setting options on a given instance
     * @return array
     */
    public function getSetOptionsProvider() {
        return array(
            array(
                new OptionsMock(),
                array(
                	'bool' => true,
                    'value' => 123,
                    'foo' => 'bar'
                ),
                array(),
                array(
                    'foo' => 'bar'
                )
            ),
            array(
                new OptionsMock(array(
                    'quz' => 123
                )),
                array(
                	'bool' => true,
                    'value' => 123,
                    'foo' => 'bar'
                ),
                array(
                    'quz' => 123
                ),
                array(
                    'quz' => 123,
                    'foo' => 'bar',
                )
            )
        );
    }
}