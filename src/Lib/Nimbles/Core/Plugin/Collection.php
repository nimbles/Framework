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
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Core\Plugin;

use Nimbles\Core,
    Nimbles\Core\Plugin;

/**
 * @category   Nimbles
 * @package    Nimbles-Core
 * @subpackage Plugin
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 *
 * @uses       \Nimbles\Core\Collection
 *
 * @uses       \Nimbles\Core\Plugin
 */
class Collection extends Core\Collection {
    /**
     * Class construct, all plugin types must be passed into the construct
     * @param array|\ArrayObject|null $array
     * @return void
     */
    public function __construct($array = null, array $options = null) {
        $options = array_merge(
            (null === $options) ? array() : $options,
            array(
                'type'      => 'Nimbles\Core\Plugin',
                'indexType' => static::INDEX_ASSOCIATIVE,
                'readonly'  => true
            )
        );

        parent::__construct($array, $options);
        $this->setFlags(self::ARRAY_AS_PROPS);
    }
    
    /**
     * Gets a plugin by name
     * @param string $name
     * @return \Nimbles\Plugin\Plugin
     */
    public function getPlugin($name) {
        return $this->offsetExists($name) ? $this[$name] : null;
    }
    
	/**
     * Factory method for creating plugins
     * @param string|int                          $index
     * @param string|array|\Nimbles\Core\Plugin $plugin
     * @return \Nimbles\Core\Plugin|null
     */
    public static function factory($index, $plugin) {
        if (is_array($plugin)) { // treat as options
            $plugin = new Plugin($plugin);
        } else if (!($plugin instanceof Plugin)) { // empty plugin
            $plugin = new Plugin();
        }
    
        $plugin->setName($index); // name name and index in sync
        return $plugin;
    }
} 