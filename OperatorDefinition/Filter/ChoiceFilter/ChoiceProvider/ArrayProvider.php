<?php

namespace Kora\DataProvider\OperatorDefinition\Filter\ChoiceFilter\ChoiceProvider;

use Kora\DataProvider\OperatorDefinition\Filter\ChoiceFilter\ChoiceProviderInterface;

/**
 * Class ArrayProvider
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
class ArrayProvider implements ChoiceProviderInterface
{
	/**
	 * @var array
	 */
	private $choices;

	/**
	 * ArrayProvider constructor.
	 * @param array $choices
	 */
	public function __construct(array $choices)
	{
		$this->choices = $choices;
	}

	/**
	 * @param $choice
	 * @return null
	 */
	public function validateChoice($choice)
	{
		return (empty($this->choices) || in_array($choice, $this->choices, true))
			? $choice
			: null;
	}

	/**
	 * @param array $choices
	 * @return array
	 */
	public function validateChoices(array $choices): array
	{
		$allowAll = empty($this->choices);
		$allowedValues = [];

		foreach ($choices as $choice) {
			if($allowAll || in_array($choice, $this->choices, true)) {
				$allowedValues[] = $choice;
			}
		}

		return $allowedValues;
	}

	/**
	 * @return array
	 */
	public function getAvailableChoices(): array
	{
		return $this->choices;
	}
}