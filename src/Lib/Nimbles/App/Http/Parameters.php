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
 * @package    Nimbles-App
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 */

namespace Nimbles\App\Http;

use Nimbles\Core\Collection;

/**
 * @category   Nimbles
 * @package    Nimbles-App
 * @subpackage Http
 * @copyright  Copyright (c) 2010 Nimbles Framework (http://nimbl.es)
 * @license    http://nimbl.es/license/mit MIT License
 * @version    $Id$
 * 
 * @uses       \Nimbles\Core\Collection
 */
class Parameters extends Collection {
    /**
     * Class construct
     * @param array|\ArrayObject|null $array
     * @param array|null $options
     * @return void
     */
    public function __construct($array = null, array $options = null) {
        $fixed = array(
            'type'      => 'string',
            'indexType' => static::INDEX_ASSOCIATIVE 
        );
        
        $options = (null == $options) ? $fixed : array_merge($options, $fixed);
        
        parent::__construct($array, $options);
        $this->setFlags(static::ARRAY_AS_PROPS);
    }
}