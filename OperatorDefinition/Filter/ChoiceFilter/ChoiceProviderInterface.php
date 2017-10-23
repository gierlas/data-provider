<?php

namespace Kora\DataProvider\OperatorDefinition\Filter\ChoiceFilter;


/**
 * Interface ChoiceProviderInterface
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
interface ChoiceProviderInterface
{
	/**
	 * @param $choice
	 * @return null|mixed
	 */
	public function validateChoice($choice);

	/**
	 * @param array $choices
	 * @return array
	 */
	public function validateChoices(array $choices): array;

	/**
	 * @return array
	 */
	public function getAvailableChoices(): array ;
}