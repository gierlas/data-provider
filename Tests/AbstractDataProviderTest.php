<?php

namespace Kora\DataProvider\Tests;

use Kora\DataProvider\AbstractDataProvider;
use Kora\DataProvider\DataProviderOperatorsSetup;
use Kora\DataProvider\Mapper;
use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;
use Kora\DataProvider\OperatorDefinition\OrderOperatorDefinitionInterface;
use Kora\DataProvider\OperatorDefinition\PagerOperatorDefinitionInterface;
use Kora\DataProvider\OperatorImplementationsList;
use Kora\DataProvider\Result;
use PHPUnit\Framework\TestCase;
use Mockery as m;


/**
 * Class AbstractDataProviderTest
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class AbstractDataProviderTest extends TestCase
{
	use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

	public function testApplySetup()
	{
		$filter = $this->getMockBuilder(FilterOperatorDefinitionInterface::class)->getMock();

		$order = $this->getMockBuilder(OrderOperatorDefinitionInterface::class)->getMock();
		$order->method('getParamValue')->willReturn([]);

		$pager = $this->getMockBuilder(PagerOperatorDefinitionInterface::class)->getMock();

		$dataProviderOperatorSetup = new DataProviderOperatorsSetup();
		$dataProviderOperatorSetup
			->addFilter($filter)
			->setOrder($order)
			->setPager($pager);

		$implementationList = m::mock(OperatorImplementationsList::class)
			->shouldDeferMissing();

		$dataProvider = m::mock(AbstractDataProvider::class, [$implementationList, new Mapper()])
			->shouldAllowMockingProtectedMethods()
			->shouldDeferMissing();

		$dataProvider
			->shouldReceive('fetchFromDataSource')
			->andReturn([])
			->once();

		$dataProvider
			->shouldReceive('count')
			->andReturn(0)
			->once();

		$implementationList
			->shouldReceive('hasImplementation')
			->times(3);

		/** @var Result $result */
		$result = $dataProvider
			->fetchData($dataProviderOperatorSetup);

		$this->assertEquals($result->getResults(), []);

	}
}