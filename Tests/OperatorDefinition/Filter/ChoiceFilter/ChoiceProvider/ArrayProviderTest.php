<?php

namespace Kora\DataProvider\Tests\OperatorDefinition\Filter\ChoiceFilter\ChoiceProvider;

use Kora\DataProvider\OperatorDefinition\Filter\ChoiceFilter\ChoiceProvider\ArrayProvider;
use PHPUnit\Framework\TestCase;

/**
 * Test ArrayProviderTest
 *
 * @author Pawel Gierlasinski <gierlasinski.pawel@gmail.com>
 **/
class ArrayProviderTest extends TestCase
{
	protected static $CHOICES = [
		'test', 'test1', 'test2', 'test3', 'test4'
	];

	/**
	 * @dataProvider validChoiceProvider
	 * @param array $availableChoices
	 * @param       $choice
	 * @param       $expectedResult
	 */
	public function testValidChoice(array $availableChoices, $choice, $expectedResult)
	{
		$arrayProvider = new ArrayProvider($availableChoices);
		$result = $arrayProvider->validateChoice($choice);

		$this->assertEquals($result, $expectedResult);
	}

	public function validChoiceProvider()
	{
		return [
			[self::$CHOICES, null, null],
			[self::$CHOICES, 'test', 'test'],
			[self::$CHOICES, 'asdf', null]
		];
	}

	/**
	 * @dataProvider validChoicesProvider
	 * @param array $availableChoices
	 * @param       $choices
	 * @param       $expectedResult
	 */
	public function testValidChoices(array $availableChoices, $choices, $expectedResult)
	{
		$arrayProvider = new ArrayProvider($availableChoices);
		$result = $arrayProvider->validateChoices($choices);

		$this->assertEquals($result, $expectedResult);
	}

	public function validChoicesProvider()
	{
		return [
			[self::$CHOICES, [], []],
			[self::$CHOICES, ['test'], ['test']],
			[self::$CHOICES, ['test', 'test1'], ['test', 'test1']],
			[self::$CHOICES, ['asdf'], []],
			[self::$CHOICES, ['asdf', 'test'], ['test']]
		];
	}
}
