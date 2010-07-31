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
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Config;

use Mu\Core\Mixin\Mixinable\MixinableAbstract,
    Mu\Core\Config;

/**
 * @category   Mu
 * @package    Mu-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license    http://mu-framework.com/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Mu\Core\Mixin\Mixinable\MixinableAbstract
 * @uses       \Mu\Core\Config
 */
class Configurable extends MixinableAbstract {
    /**
     * The config for this mixinable
     * @var \Mu\Core\Config
     */
    protected $_config;

    /**
     * Gets the object associated with this mixin
     * @return \Mu\Core\Config
     */
    public function getObject() {
        if (null === $this->_config) {
            $this->_config = new Config();
        }

        return $this->_config;
    }

    /**
     * Gets the properties which can be mixed in
     * @return array
     */
    public function getProperties() {
        if (null === $this->_properties) {
            $this->_properties = array(
                'config' => function($object, &$config, $get, $property, array $value = null) {
                    if (!$get) {
                        return $config->setConfig($value);
                    }

                    return $config;
                }
            );
        }

        return $this->_properties;
    }
}
