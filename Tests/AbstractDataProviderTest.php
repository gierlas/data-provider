<?php

namespace Kora\DataProvider\Tests;

use Kora\DataProvider\AbstractDataProvider;
use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;
use Kora\DataProvider\OperatorDefinition\OrderOperatorDefinitionInterface;
use Kora\DataProvider\OperatorDefinition\PagerOperatorDefinitionInterface;
use Kora\DataProvider\Tests\Fixtures\FooDataProvider;
use PHPUnit\Framework\TestCase;
use Mockery as m;


/**
 * Class AbstractDataProviderTest
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class AbstractDataProviderTest extends TestCase
{
	public function testFilterAddedToOperators()
	{
		$filter = $this->getMockBuilder(FilterOperatorDefinitionInterface::class)->getMock();
		$dataProvider = m::spy(AbstractDataProvider::class)->makePartial();

		$this->assertEmpty($dataProvider->getOperators());
		$dataProvider->addFilter($filter);
		$this->assertCount(1, $dataProvider->getOperators());

		$dataProvider->shouldHaveReceived('addOperator')->once();
	}

	public function testOrderAddedToOperators()
	{
		$order = $this->getMockBuilder(OrderOperatorDefinitionInterface::class)->getMock();
		$dataProvider = m::spy(AbstractDataProvider::class)->makePartial();

		$this->assertEmpty($dataProvider->getOperators());
		$dataProvider->setOrder($order);
		$this->assertCount(1, $dataProvider->getOperators());

		$dataProvider->shouldHaveReceived('addOperator')->once();
	}

	public function testPagerAddedToOperators()
	{
		$pager = $this->getMockBuilder(PagerOperatorDefinitionInterface::class)->getMock();
		$dataProvider = m::spy(AbstractDataProvider::class)->makePartial();

		$this->assertEmpty($dataProvider->getOperators());
		$dataProvider->setPager($pager);
		$this->assertCount(1, $dataProvider->getOperators());

		$dataProvider->shouldHaveReceived('addOperator')->once();
	}
}