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
		[
			[[], null, null]
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
		[
			[[], null, null]
		];
	}
}
