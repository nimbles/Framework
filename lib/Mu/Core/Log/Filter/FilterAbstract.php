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
 * @category  \Mu\Core
 * @package   \Mu\Core\Log\Filter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Log\Filter;

use \Mu\Core\Mixin\MixinAbstract,
    \Mu\Core\Log\Entry;

/**
 * @category  \Mu\Core
 * @package   \Mu\Core\Log\Filter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 * @version   $Id$
 *
 * @uses      \Mu\Core\Mixin\MixinAbstract
 * @uses      \Mu\Core\Config\Options
 * @uses      \Mu\Core\Log\Entry
 */
abstract class FilterAbstract extends MixinAbstract {
    /**
     * Mixin implements
     * @var array
     */
    protected $_implements = array('Mu\Core\Config\Options');

    /**
     * Class construct
     * @param array|\ArrayObject $options
     * @return void
     */
    public function __construct($options) {
        parent::__construct();
        $this->setOptions($options);
    }

    /**
     * Filters the entry
     * @param \Mu\Core\Log\Entry $entry
     * @return bool
     */
    abstract public function apply(Entry $entry);
}
