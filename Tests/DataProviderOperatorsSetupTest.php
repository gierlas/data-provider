<?php

namespace Kora\DataProvider\Tests;

use Kora\DataProvider\DataProviderOperatorsSetup;
use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;
use Kora\DataProvider\OperatorDefinition\OrderOperatorDefinitionInterface;
use Kora\DataProvider\OperatorDefinition\PagerOperatorDefinitionInterface;
use PHPUnit\Framework\TestCase;
use Mockery as m;

/**
 * Class DataProviderOperatorsSetupTest
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class DataProviderOperatorsSetupTest extends TestCase
{
	public function testFilterAddedToOperators()
	{
		$filter = $this->getMockBuilder(FilterOperatorDefinitionInterface::class)->getMock();
		$dataProviderOperatorSetup = m::spy(DataProviderOperatorsSetup::class)->makePartial();

		$this->assertEmpty($dataProviderOperatorSetup->getOperators());
		$dataProviderOperatorSetup->addFilter($filter);
		$this->assertCount(1, $dataProviderOperatorSetup->getOperators());

		$dataProviderOperatorSetup->shouldHaveReceived('addOperator')->once();
	}

	public function testOrderAddedToOperators()
	{
		$order = $this->getMockBuilder(OrderOperatorDefinitionInterface::class)->getMock();
		$dataProviderOperatorSetup = m::spy(DataProviderOperatorsSetup::class)->makePartial();

		$this->assertEmpty($dataProviderOperatorSetup->getOperators());
		$dataProviderOperatorSetup->setOrder($order);
		$this->assertCount(1, $dataProviderOperatorSetup->getOperators());

		$dataProviderOperatorSetup->shouldHaveReceived('addOperator')->once();
	}

	public function testPagerAddedToOperators()
	{
		$pager = $this->getMockBuilder(PagerOperatorDefinitionInterface::class)->getMock();
		$dataProviderOperatorSetup = m::spy(DataProviderOperatorsSetup::class)->makePartial();

		$this->assertEmpty($dataProviderOperatorSetup->getOperators());
		$dataProviderOperatorSetup->setPager($pager);
		$this->assertCount(1, $dataProviderOperatorSetup->getOperators());

		$dataProviderOperatorSetup->shouldHaveReceived('addOperator')->once();
	}
}
