<?php

namespace Kora\DataProvider\Tests\OperatorDefinition\Filter;

use Kora\DataProvider\OperatorDefinition\Filter\DateFilterDefinition;
use PHPUnit\Framework\TestCase;

/**
 * Class DateFilterDefinitionTest
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class DateFilterDefinitionTest extends TestCase
{
	/**
	 * @dataProvider initDataProvider
	 * @param $format
	 * @param $input
	 * @param $expectedDate
	 */
	public function testInitData($format, $input, $expectedDate)
	{
		$name = 'test';
		$dateFilterDefinition = new DateFilterDefinition($name, $format);

		$dateFilterDefinition->initData([$name => $input]);

//		$this->assertEquals($expectedDate, $dateFilterDefinition->getDate());
		$this->assertEquals(!empty($input) ? [ $name => $input ] : null, $dateFilterDefinition->getParamValue());
	}

	public function initDataProvider()
	{
		return [
			['Y-m-d', '2017-05-31', \DateTime::createFromFormat('Y-m-d', '2017-05-31')],
			[null, '2017-05-31', new \DateTime('2017-05-31')],
			[null, null, null]
		];
	}

	/**
	 * @expectedException \Exception
	 */
	public function testInitDataWrongDate()
	{
		$name = 'test';
		$dateFilterDefinition = new DateFilterDefinition($name);

		$dateFilterDefinition->initData([$name => 'asdf']);
	}

	/**
	 * @expectedException \InvalidArgumentException
	 */
	public function testInitDataWrongDateWithFromat()
	{
		$name = 'test';
		$dateFilterDefinition = new DateFilterDefinition($name, 'Y-m-d');

		$dateFilterDefinition->initData([$name => 'asdf']);
	}
}
