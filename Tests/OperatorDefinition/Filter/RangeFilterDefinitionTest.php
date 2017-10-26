<?php

namespace Kora\DataProvider\Tests\OperatorDefinition\Filter;

use Kora\DataProvider\OperatorDefinition\Filter\RangeFilterDefinition;
use PHPUnit\Framework\TestCase;

/**
 * Class RangeFilterDefinitionTest
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class RangeFilterDefinitionTest extends TestCase
{
	/**
	 * @dataProvider initDataProvider
	 * @param $filter
	 * @param $input
	 * @param $expectedMin
	 * @param $expectedMax
	 */
	public function testInitData($filter, $input, $expectedMin, $expectedMax)
	{
		$name = 'test';

		$definition = new RangeFilterDefinition($name, $filter);

		$definition->initData([
			$name => $input
		]);

		$this->assertEquals($expectedMin, $definition->getMin());
		$this->assertEquals($expectedMax, $definition->getMax());
	}

	/**
	 * @return array
	 */
	public function initDataProvider()
	{
		return [
			[FILTER_SANITIZE_NUMBER_INT, ['min' => 1, 'max' => 2], 1, 2],
			[FILTER_SANITIZE_NUMBER_INT, ['min' => '1', 'max' => '2'], 1, 2],
			[FILTER_SANITIZE_NUMBER_INT, ['min' => '1', 'maxa' => '2'], 1, null],
			[FILTER_SANITIZE_NUMBER_INT, ['min' => '1'], 1, null],
			[FILTER_SANITIZE_NUMBER_INT, ['max' => 2], null, 2],
			[FILTER_SANITIZE_NUMBER_INT, [], null, null],
			[FILTER_SANITIZE_NUMBER_FLOAT, ['min' => 1, 'max' => 2], 1.0, 2.0],
		];
	}
}
