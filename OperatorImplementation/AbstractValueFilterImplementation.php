<?php

namespace Kora\DataProvider\OperatorImplementation;

use Kora\DataProvider\DataProviderInterface;
use Kora\DataProvider\OperatorDefinition\Filter\AbstractValueDefinition;
use Kora\DataProvider\OperatorDefinitionInterface;
use Kora\DataProvider\OperatorImplementationInterface;


/**
 * Class AbstractValueFilterImplementation
 * @author Paweł Gierlasiński <pawel@mediamonks.com>
 */
abstract class AbstractValueFilterImplementation implements OperatorImplementationInterface
{
	/**
	 * @param DataProviderInterface       $dataProvider
	 * @param OperatorDefinitionInterface $definition
	 */
	public function apply(DataProviderInterface $dataProvider, OperatorDefinitionInterface $definition)
	{
		/** @var AbstractValueDefinition $definition */
		if(!$definition->shouldApply()) return;

		$this->_apply($dataProvider, $definition);
	}

	/**
	 * @param DataProviderInterface       $dataProvider
	 * @param OperatorDefinitionInterface $definition
	 */
	abstract protected function _apply(DataProviderInterface $dataProvider, OperatorDefinitionInterface $definition);
}