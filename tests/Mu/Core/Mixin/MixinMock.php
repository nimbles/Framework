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
 * @package   \Mu\Core\Mixin
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 * @license   http://mu-framework.com/license/mit MIT License
 */

namespace Tests\Mu\Core\Mixin;

class MixinEmpty extends \Mu\Core\Mixin\MixinAbstract {}
class MixinInvalid extends \Mu\Core\Mixin\MixinAbstract {
    protected $_implements = array('\Invalid\Class');
}
