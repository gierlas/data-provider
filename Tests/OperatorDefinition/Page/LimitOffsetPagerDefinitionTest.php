<?php

namespace Kora\DataProvider\Tests\OperatorDefinition\Page;

use Kora\DataProvider\OperatorDefinition\Pager\LimitOffsetPagerDefinition;
use PHPUnit\Framework\TestCase;


/**
 * Class LimitOffsetPagerDefinitionTest
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class LimitOffsetPagerDefinitionTest extends TestCase
{
	public function testDefaultValues()
	{
		$defaultOffset = 5;
		$defaultLimit = 10;
		$data = [];

		$limitOffsetPagerDefinition = new LimitOffsetPagerDefinition($defaultOffset, $defaultLimit);
		$limitOffsetPagerDefinition->initData($data);

		$this->assertEquals($defaultOffset, $limitOffsetPagerDefinition->getOffset());
		$this->assertEquals($defaultLimit, $limitOffsetPagerDefinition->getLimit());
	}

	public function testParamName()
	{
		$offset = 5;
		$limit = 10;
		$offsetName = 'off';
		$limitName = 'lim';

		$limitOffsetPagerDefinition = new LimitOffsetPagerDefinition(0, 20, $limitName, $offsetName);

		$data = [ $offsetName => $offset, $limitName => $limit ];
		$limitOffsetPagerDefinition->initData($data);

		$this->assertEquals($offset, $limitOffsetPagerDefinition->getOffset());
		$this->assertEquals($limit, $limitOffsetPagerDefinition->getLimit());

		$this->assertSame($data, $limitOffsetPagerDefinition->getParamValue());
	}
}