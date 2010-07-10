<?php
/**
 * Mu Framework
 *
 * LICENSE
 *
 * This shouce file is subject to the MIT license that is bundled
 * with the package in the file LICENSE.md.
 * It is also available at this URL:
 * http://mu-framework.com/license/mit
 *
 * @category  Mu\Core
 * @package   Mu\Core\Log\Filter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Mu\Core\Log;

/**
 * @category  Mu\Core
 * @package   Mu\Core\Log\Filter
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */
abstract class Filter extends \Mu\Core\Mixin {
	/**
	 * Mixin implements
	 * @var array
	 */
	protected $_implements = array('Mu\Core\Config\Options');

	/**
	 * Class construct
	 * @param array|\ArrayObject $options
	 */
	public function __construct($options) {
		parent::__construct();
		$this->setOptions($options);
	}

	/**
	 * Filters the entry
	 * @param \Mu\Core\Log\Entry $entry
	 */
	abstract public function apply(Entry $entry);
}