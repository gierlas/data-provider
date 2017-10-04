<?php
namespace Kora\DataProvider\Tests\OperatorImplementation\Filter;

use Kora\DataProvider\DataProviderInterface;
use Kora\DataProvider\OperatorDefinition\Filter\CallbackFilterDefinition;
use Kora\DataProvider\OperatorImplementation\Filter\CallbackFilterImplementation;
use PHPUnit\Framework\TestCase;
use Mockery as m;

/**
 * Class CallbackFilterDefinitionTest
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class CallbackFilterDefinitionTest extends TestCase
{
	use m\Adapter\Phpunit\MockeryPHPUnitIntegration;

	public function tearDown()
	{
		parent::tearDown();
		m::close();
	}

	/**
	 * @dataProvider applyProvider
	 * @param $name
	 * @param $allowEmpty
	 * @param $data
	 * @param $shouldCallbackBeExecuted
	 */
	public function testApply($name, $allowEmpty, $data, $shouldCallbackBeExecuted)
	{
		$callback = $this->getCallbackMock($shouldCallbackBeExecuted);

		$callbackDefinitions = m::mock(CallbackFilterDefinition::class, [
			$name, [$callback, 'callback'], $allowEmpty
		]);
		$callbackDefinitions->shouldDeferMissing();

		$dataProvider = m::mock(DataProviderInterface::class)->makePartial();

		$callbackDefinitions->initData($data);

		$callbackFilter = new CallbackFilterImplementation();

		$callbackFilter->apply($dataProvider, $callbackDefinitions);
	}

	public function applyProvider()
	{
		$name = 'test';
		return [
			[$name, true, [$name => 'data'], true],
			[$name, true, [ ], true],
			[$name, false, [ ], false],
		];
	}

	/**
	 * @param bool $shouldBeCalled
	 * @return m\MockInterface
	 */
	protected function getCallbackMock(bool $shouldBeCalled)
	{
		$mock = m::mock();
		if($shouldBeCalled) {
			$mock
				->shouldReceive('callback')
				->andReturn('dupa')
				->once();
		} else {
			$mock
				->shouldReceive('callback')
				->never();
		}

		return $mock->makePartial();
	}
}
