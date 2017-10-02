<?php

namespace Kora\DataProvider\Tests\OperatorDefinition\Filter;

use Kora\DataProvider\OperatorDefinition\Filter\AbstractValueDefinition;
use PHPUnit\Framework\TestCase;

/**
 * Class AbstractValueDefinitionTest
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class AbstractValueDefinitionTest extends TestCase
{
	/**
	 * @param string $name
	 * @param bool   $allowUseEmpty
	 * @param int    $filterType
	 * @return \PHPUnit_Framework_MockObject_MockObject|AbstractValueDefinition
	 */
	protected function getValueDefinitionMock(string $name, bool $allowUseEmpty = false, $filterType = FILTER_SANITIZE_STRING)
	{
		return $this
			->getMockBuilder(AbstractValueDefinition::class)
			->setConstructorArgs([$name, $allowUseEmpty, $filterType])
			->getMockForAbstractClass();
	}

	/**
	 * @dataProvider initDataProvider
	 * @param string $name
	 * @param bool   $allowEmpty
	 * @param        $filter
	 * @param array  $data
	 * @param        $expectedValue
	 * @param bool   $shouldApply
	 */
	public function testInitData(string $name, bool $allowEmpty, $filter, array $data, $expectedValue, bool $shouldApply)
	{
		$valueDefinition = $this->getValueDefinitionMock($name, $allowEmpty, $filter);

		$valueDefinition->initData($data);

		$this->assertEquals($expectedValue, $valueDefinition->getValue());
		$this->assertEquals($shouldApply, $valueDefinition->shouldApply());
		$expectedParam = $shouldApply ? [$name => $expectedValue] : null;
		$this->assertEquals($expectedParam, $valueDefinition->getParamValue());
	}

	public function initDataProvider()
	{
		$paramName = 'test';

		return [
			[$paramName, false, FILTER_SANITIZE_STRING, [$paramName => 'asdf'], 'asdf', true],
			[$paramName, false, FILTER_SANITIZE_STRING, [], null, false],
			[$paramName, true, FILTER_SANITIZE_STRING, [], null, true],
			[$paramName, true, FILTER_SANITIZE_STRING, ['asdf' => 'sadf'], null, true],
			[$paramName, true, FILTER_SANITIZE_STRING, [$paramName => [
				'test' => '1',
				'test1' => '2'
			]], null, true],
		];
	}
}
