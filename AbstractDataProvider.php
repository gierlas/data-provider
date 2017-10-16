<?php

namespace Kora\DataProvider;

use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;
use Kora\DataProvider\OperatorDefinition\OrderOperatorDefinitionInterface;
use Kora\DataProvider\OperatorDefinition\PagerOperatorDefinitionInterface;


/**
 * Class AbstractDataProvider
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
abstract class AbstractDataProvider implements DataProviderInterface
{
	/**
	 * @var OperatorImplementationsList
	 */
	private $implementationsList;

	/**
	 * @var array
	 */
	private $mapping;

	/**
	 * AbstractDataProvider constructor.
	 * @param OperatorImplementationsList $implementationsList
	 * @param array                       $mapping
	 */
	public function __construct(OperatorImplementationsList $implementationsList, array $mapping = [])
	{
		$this->implementationsList = $implementationsList;
		$this->mapping = $mapping;
	}

	/**
	 * @return array
	 */
	public function getMapping(): array
	{
		return $this->mapping;
	}

	/**
	 * @param DataProviderOperatorsSetup $setup
	 */
	protected function applySetup(DataProviderOperatorsSetup $setup)
	{
		foreach ($setup->getOperators() as $operator) {
			$operatorCode = OperatorImplementationsList::getOperatorCode($operator);

			if (!$this->implementationsList->hasImplementation($operatorCode)) continue;

			$operatorImplementation = $this->implementationsList->getImplementation($operatorCode);

			$operatorImplementation->apply($this, $operator);
		}
	}

	/**
	 * @param DataProviderOperatorsSetup $setup
	 * @return Result
	 */
	public function fetchData(DataProviderOperatorsSetup $setup): Result
	{
		$this->applySetup($setup);

		$data = $this->fetchFromDataSource();
		$count = $this->count();

		return new Result($setup, $data, $count);
	}

	/**
	 * @return array
	 */
	abstract protected function fetchFromDataSource(): array;

}