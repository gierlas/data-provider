<?php


namespace Kora\DataProvider;


/**
 * Interface OperatorImplementationInterface
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
interface OperatorImplementationInterface
{
	/**
	 * @return string
	 */
	public function getOperatorDefinitionCode(): string;

	/**
	 * Apply operator to data provider
	 * @param DataProviderInterface $dataProvider
	 * @param OperatorDefinitionInterface $definition
	 */
	public function apply(DataProviderInterface $dataProvider, OperatorDefinitionInterface $definition);

}