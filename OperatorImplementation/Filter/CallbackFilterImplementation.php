<?php

namespace Kora\DataProvider\OperatorImplementation\Filter;

use Kora\DataProvider\DataProviderInterface;
use Kora\DataProvider\OperatorDefinition\Filter\CallbackFilterDefinition;
use Kora\DataProvider\OperatorDefinitionInterface;
use Kora\DataProvider\OperatorImplementation\AbstractValueFilterImplementation;


/**
 * Class CallbackFilterImplementation
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class CallbackFilterImplementation extends AbstractValueFilterImplementation
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
	protected function _apply(DataProviderInterface $dataProvider, OperatorDefinitionInterface $definition)
	{
		/** @var CallbackFilterDefinition $definition */
		call_user_func(
			$definition->getCallback(),
			$dataProvider, $definition->getName(), $definition->getValue(), $definition->getWholePayload()
		);
	}
}