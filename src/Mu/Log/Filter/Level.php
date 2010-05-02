<?php
namespace Mu\Log\Filter;

/**
 * @category Mu
 * @package Mu\Log\Filter\Level
 * @copyright Copyright (c) 2010 Mu Framework (http://mu-framework.com)
 */
class Level extends \Mu\Log\Filter {
	/**
	 * level filter types
	 */
	const LEVEL_INCLUDE = 0;
	const LEVEL_EXCLUDE	= 1;
	const LEVEL_ABOVE 	= 2;
	const LEVEL_BELOW	= 3;
	
	/**
	 * Mixin implements
	 * @var array
	 */
	protected $_implements = array(
		'Mu\Config\Options' => array(
			'type' => self::LEVEL_ABOVE,
			'level' => LOG_NOTICE
		)
	);
	
	/**
	 * Filters based on level
	 * @param \Mu\Log\Entry $entry
	 */
	public function filter(\Mu\Log\Entry $entry) {
		$levels = $this->getOption('level');
		
		switch ($this->getOption('type')) {
			case self::LEVEL_ABOVE :
				if (!is_int($levels) || ($levels < 0) || ($levels > 7)) {
					throw Exception\InvalidLevel('Level must be a valid level between LOG_DEBUG and LOG_EMERG');
				}
				
				return $entry->getLevel() <= $this->getOption('level');
				break;
				
			case self::LEVEL_BELOW :
				if (!is_int($levels) || ($levels < 0) || ($levels > 7)) {
					throw Exception\InvalidLevel('Level must be a valid level between LOG_DEBUG and LOG_EMERG');
				}
				
				return $entry->getLevel() >= $this->getOption('level');
				break;
				
			case self::LEVEL_INCLUDE :
			case self::LEVEL_EXCLUDE :
				if (!is_array($levels) && !($levels instanceof \ArrayObject)) {
					$levels = array($levels);
				}
				
				foreach ($levels as $level) {
					if (!is_int($level) || ($level < 0) || ($level > 7)) {
						throw Exception\InvalidLevel('Level must be a valid level between LOG_DEBUG and LOG_EMERG');
					}
					
					if (self::LEVEL_INCLUDE === $this->getOption('type')) {
						if ($entry->getLevel() !== $level) {
							return false;
						}
					} else {
						if ($entry->getLevel() === $level) {
							return false;
						}
					}
				}
				
				break;
		}
		
		return false;
	}
}