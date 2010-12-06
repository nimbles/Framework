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
 * @subpackage Pattern
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */
namespace Nimbles\Core\Pattern;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Pattern
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 */
trait Multiton {
    /**
     * Gets an instance of the class based on arguements.
     * @return object
     */
    public static function getInstance() {
        static $instances;

        if (null === $instances) {
            $instances = array();
        }

        $args = func_get_args();
        $key = serialize($args);

        if (!array_key_exists($key, $instances)) {
            $instances[$key] = \Nimbles\Core\Util\Instance::getInstance(get_class(), $args);
        }

        return $instances[$key];
    }
}