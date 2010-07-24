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
 * @package   Mu\Core\Delegates
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Mu\Core\Delegates;

/**
 * @category  Mu
 * @package   Mu\Core\Delegates
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
class DelegatableMock extends \Mu\Core\Mixin\MixinAbstract {
    /**
     * The implements for this mock, adds 2 delegates methods
     * @var array
     */
    protected $_implements = array('Mu\Core\Delegates\Delegatable' => array(
        'delegates' => array(
            'method1' => array('\Tests\Mu\Core\Delegates\DelegatableMock', 'similuatedMethod1'),
    		'method2' => array('\Tests\Mu\Core\Delegates\DelegatableMock', 'similuatedMethod2'),
        )
    ));

    /**
     * A similuated method
     * @return bool
     */
    static public function similuatedMethod1() {
        return true;
    }

    /**
     * A similuated method
     * @return bool
     */
    static public function similuatedMethod2() {
        return false;
    }
}