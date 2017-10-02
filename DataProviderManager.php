<?php

namespace Kora\DataProvider;

use Kora\DataProvider\Exception\MissingOperatorsImplementationsException;


/**
 * Class DataProviderManager
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class DataProviderManager
{
	/**
	 * @var OperatorImplementationsList[]
	 */
	protected $dataProvidersOperatorImplementations = [];

	/**
	 * @param string                      $code
	 * @param OperatorImplementationsList $implementations
	 *
	 * @return DataProviderManager
	 */
	public function addImplementationList(string $code, OperatorImplementationsList $implementations): self
	{
		$this->dataProvidersOperatorImplementations[$code] = $implementations;

		return $this;
	}

	/**
	 * @param string $code
	 * @return OperatorImplementationsList
	 */
	public function getImplementations(string $code)
	{
		return $this->dataProvidersOperatorImplementations[$code];
	}

	/**
	 * @param string $code
	 *
	 * @return bool
	 */
	public function hasImplementations(string $code): bool
	{
		return isset($this->dataProvidersOperatorImplementations[$code]);
	}

	/**
	 * @param DataProviderInterface $dataProvider
	 * @param array                 $params
	 *
	 * @return Result
	 * @throws MissingOperatorsImplementationsException
	 */
	public function fetchData(DataProviderInterface $dataProvider, array $params): Result
	{
		$dataProviderCode = self::getDataProviderCode($dataProvider);

		if (!$this->hasImplementations($dataProviderCode)) {
			throw new MissingOperatorsImplementationsException($dataProvider);
		}

		$operatorImplementations = $this->getImplementations($dataProviderCode);

		foreach ($dataProvider->getOperators() as $operator) {
			$operatorCode = OperatorImplementationsList::getOperatorCode($operator);

			if (!$operatorImplementations->hasImplementation($operatorCode)) continue;

			$operatorImplementation = $operatorImplementations->getImplementation($operatorCode);

			$operator->initData($params);
			$operatorImplementation->apply($dataProvider, $operator);
		}

		$count = $dataProvider->count();
		$results = $dataProvider->fetchData();

		return new Result($dataProvider, $results, $count);
	}

	/**
	 * @param DataProviderInterface $dataProvider
	 * @return string
	 */
	public static function getDataProviderCode(DataProviderInterface $dataProvider): string
	{
		return get_class($dataProvider);
	}
}