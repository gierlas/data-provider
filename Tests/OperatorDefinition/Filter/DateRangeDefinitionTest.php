<?php

namespace Kora\DataProvider\Tests\OperatorDefinition\Filter;

use Kora\DataProvider\OperatorDefinition\Filter\DateRangeDefinition;
use PHPUnit\Framework\TestCase;

/**
 * Class DateRangeDefinitionTest
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class DateRangeDefinitionTest extends TestCase
{
	/**
	 * @dataProvider initDataProvider
	 * @param $format
	 * @param $input
	 * @param $expectedStart
	 * @param $expectedEnd
	 */
	public function testInitData($format, $input, $expectedStart, $expectedEnd)
	{
		$name = 'test';
		$dateFilterDefinition = new DateRangeDefinition($name, $format);

		$dateFilterDefinition->initData([$name => $input]);

		$this->assertEquals($expectedStart, $dateFilterDefinition->getDateStart());
		$this->assertEquals($expectedEnd, $dateFilterDefinition->getDateEnd());
		$this->assertEquals(!empty($input) ? [ $name => $input ] : null, $dateFilterDefinition->getParamValue());
	}

	/**
	 * @return array
	 */
	public function initDataProvider()
	{
		$start = DateRangeDefinition::DATE_START_NAME;
		$end = DateRangeDefinition::DATE_END_NAME;

		return [
			[null, [ $start => '2015-05-10', $end => '2015-05-10' ], new \DateTime('2015-05-10'), new \DateTime('2015-05-10')],
			[null, [ $start => '2015-05-10' ], new \DateTime('2015-05-10'), null],
			[null, [ $end => '2015-05-10' ], null, new \DateTime('2015-05-10')],
			[null, [ ], null, null]

		];
	}
}
