<?php
namespace Tests\Mu\Core\Log\Filter;


/**
 * Category Filter Tests
 * @author rob
 *
 */
class CategoryTest extends \Mu\Core\TestCase {
	public function testCategory() {
		$filter = new \Mu\Core\Log\Filter\Category(array(
			'category' => 'hit'
		));
		
		$this->assertTrue($filter->apply(new \Mu\Core\Log\Entry(array(
			'message' => 'This is a test message',
			'category' => 'hit'
		))));
		
		$this->assertFalse($filter->apply(new \Mu\Core\Log\Entry(array(
			'message' => 'This is a test message',
			'category' => 'miss'
		))));
		
		$this->assertFalse($filter->apply(new \Mu\Core\Log\Entry(array(
			'message' => 'This is a test message'
		))));
	}
	
	public function testMissingCategory() {
		$this->setExpectedException('\Mu\Core\Log\Filter\Exception\InvalidCategory');
		
		$filter = new \Mu\Core\Log\Filter\Category(array());
		
		$filter->apply(new \Mu\Core\Log\Entry(array(
			'message' => 'This is a test message',
			'category' => 'hit'
		)));
	}
}