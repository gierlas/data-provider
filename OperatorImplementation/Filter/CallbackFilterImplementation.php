<?php

namespace Kora\DataProvider\OperatorImplementation\Filter;

use Kora\DataProvider\DataProviderInterface;
use Kora\DataProvider\OperatorDefinition\Filter\CallbackFilterDefinition;
use Kora\DataProvider\OperatorDefinitionInterface;
use Kora\DataProvider\OperatorImplementationInterface;


/**
 * Class CallbackFilterImplementation
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class CallbackFilterImplementation implements OperatorImplementationInterface
{
	/**
	 * @return string
	 */
	public function getOperatorDefinitionCode(): string
	{
		return CallbackFilterDefinition::class;
	}

	/**
	 * @param DataProviderInterface       $dataProvider
	 * @param OperatorDefinitionInterface $definition
	 */
	public function apply(DataProviderInterface $dataProvider, OperatorDefinitionInterface $definition)
	{
		/** @var CallbackFilterDefinition $definition */

		if(!$definition->shouldApply()) return;

		call_user_func(
			$definition->getCallback(),
			$dataProvider, $definition->getName(), $definition->getValue(), $definition->getWholePayload()
		);
	}
}