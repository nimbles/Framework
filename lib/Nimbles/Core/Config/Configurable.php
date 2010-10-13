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

namespace Nimbles\Core\Config;

use Nimbles\Core\Mixin\Mixinable\MixinableAbstract,
    Nimbles\Core\Config;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Config
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Mixin\Mixinable\MixinableAbstract
 * @uses       \Nimbles\Core\Config
 */
class Configurable extends MixinableAbstract {
    /**
     * The config for this mixinable
     * @var \Nimbles\Core\Config
     */
    protected $_config;

    /**
     * Gets the object associated with this mixin
     * @return \Nimbles\Core\Config
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
