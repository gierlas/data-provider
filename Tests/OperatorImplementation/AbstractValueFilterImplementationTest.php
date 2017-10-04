<?php

namespace Kora\DataProvider\Tests\OperatorImplementation;

use Kora\DataProvider\DataProviderInterface;
use Kora\DataProvider\OperatorDefinition\Filter\AbstractValueDefinition;
use Kora\DataProvider\OperatorImplementation\AbstractValueFilterImplementation;
use PHPUnit\Framework\TestCase;
use Mockery as m;

/**
 * Class AbstractValueFilterImplementationTest
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class AbstractValueFilterImplementationTest extends TestCase
{
	use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

	public function testApply()
	{
		$dataProvider = m::mock(DataProviderInterface::class);

		$filterDefinition = m::mock(AbstractValueDefinition::class);
		$filterDefinition->shouldReceive('shouldApply')
			->andReturn(true)
			->once();

		$filterImplementation = m::mock(AbstractValueFilterImplementation::class)
			->shouldAllowMockingProtectedMethods()
			->shouldDeferMissing();

		$filterImplementation
			->shouldReceive('_apply')
			->with($dataProvider, $filterDefinition)
			->once();

		$filterImplementation
			->apply($dataProvider, $filterDefinition);
	}
}
