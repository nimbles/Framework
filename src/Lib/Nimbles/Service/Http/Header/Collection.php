<?php
/**
 * Nimbles Framework
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://Nimbles-framework.com/license/mit
 *
 * @category   Nimbles
 * @package    Nimbles-Service
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\Service\Http\Header;

use Nimbles\Core,
    Nimbles\Service\Http\Header;

/**
 * @category   Nimbles
 * @package    Nimbles-Service
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 * 
 * @uses       \Nimbles\Core\Collection
 */
class Collection extends Core\Collection {
	/**
     * Class construct
     * @param array|\ArrayObject|null $array
     * @param array|null $options
     * @return void
     */
    public function __construct($array = null, array $options = null) {
        $fixed = array(
            'type'      => 'Nimbles\Service\Http\Header',
            'indexType' => static::INDEX_ASSOCIATIVE
        );
        
        $options = (null == $options) ? $fixed : array_merge($options, $fixed);
        parent::__construct($array, $options);
    }
    
    /**
     * Creates a header, header name will be synced to index
     * 
     * This method automatically called by offsetSet
     * @param int|string $index
     * @param mixed      $value
     * @return mixed
     */
    public static function factory($index, $value) {        
        if (is_string($value)) {
            return new Header(
                array($value),
                array(
                    'name' => $index
                )
            );
        }
        
        if (is_array($value)) {
            return new Header(
                $value,
                array(
                    'name' => $index
                )
            );
        }
        
        if ($value instanceof Header) {
            $value->setName($index);
            return $value;
        }
        
        return null;
    }
}