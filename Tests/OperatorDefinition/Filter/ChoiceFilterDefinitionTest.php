<?php

namespace Kora\DataProvider\Tests\OperatorDefinition\Filter;

use Kora\DataProvider\OperatorDefinition\Filter\ChoiceFilter\ChoiceProvider\ArrayProvider;
use Kora\DataProvider\OperatorDefinition\Filter\ChoiceFilter\ChoiceProviderInterface;
use Kora\DataProvider\OperatorDefinition\Filter\ChoiceFilterDefinition;
use PHPUnit\Framework\TestCase;

/**
 * Test ChoiceFilterDefinitionTest
 *
 * @author Pawel Gierlasinski <gierlasinski.pawel@gmail.com>
 **/
class ChoiceFilterDefinitionTest extends TestCase
{
	/**
	 * @dataProvider initDataProvider
	 * @param bool                    $isMulti
	 * @param ChoiceProviderInterface $choiceProvider
	 * @param                         $input
	 * @param                         $expectedValue
	 */
	public function testInitData(bool $isMulti, ChoiceProviderInterface $choiceProvider, $input, $expectedValue)
	{
		$name = 'test';
		$filterDefinition = new ChoiceFilterDefinition($name, $choiceProvider, $isMulti);

		$value = [$name => $input];

		$filterDefinition->initData($value);

		$this->assertEquals($isMulti, $filterDefinition->isMulti());
		$this->assertEquals($filterDefinition->getValue(), $expectedValue);
	}

	public function initDataProvider()
	{
		$choices = ['test', 'test1', 'test2', 'test3'];

		return [
			[false, new ArrayProvider($choices), 'test', 'test'],
			[false, new ArrayProvider($choices), 'asdf', null],
			[true, new ArrayProvider($choices), ['test'], ['test']],
			[true, new ArrayProvider($choices), ['asdf'], []],
			[true, new ArrayProvider($choices), ['test', 'test1'], ['test', 'test1']],
			[true, new ArrayProvider($choices), ['test', 'asdf'], ['test']]
		];
	}
}