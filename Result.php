<?php

namespace Kora\DataProvider;

use Kora\DataProvider\DataProviderOperatorsSetup;
use Kora\DataProvider\OperatorDefinition\PaginatorInterface;


/**
 * Class Result
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class Result
{
	/**
	 * @var DataProviderOperatorsSetup
	 */
	private $dataProviderOperatorsSetup;

	/**
	 * @var array
	 */
	private $results;

	/**
	 * @var bool
	 */
	private $hasPaginator;

	/**
	 * @var PaginatorInterface
	 */
	private $paginator;

	/**
	 * @var bool
	 */
	private $hasOrder;

	/**
	 * @var int
	 */
	private $nbAll;

	/**
	 * @var array
	 */
	private $filterParams = [];

	/**
	 * Result constructor.
	 * @param DataProviderOperatorsSetup $dataProviderOperatorsSetup
	 * @param array                 $results
	 * @param int                   $nbAll
	 */
	public function __construct(DataProviderOperatorsSetup $dataProviderOperatorsSetup, array $results, int $nbAll)
	{
		$this->dataProviderOperatorsSetup = $dataProviderOperatorsSetup;
		$this->results = $results;
		$this->nbAll = $nbAll;

		$this->hasOrder = $this->dataProviderOperatorsSetup->getOrder() !== null;
		$this->hasPaginator = $this->dataProviderOperatorsSetup->getPager() !== null;

		$this->init();
	}

	protected function init()
	{
		foreach ($this->dataProviderOperatorsSetup->getFilters() as $filter) {
			$value = $filter->getParamValue();
			if(empty($value)) continue;
			$this->filterParams += $value;
		}

		$orderParams = [];
		if($this->dataProviderOperatorsSetup->getOrder() !== null) {
			$orderParams = $this->dataProviderOperatorsSetup->getOrder()->getParamValue();
			$this->dataProviderOperatorsSetup->getOrder()->setExtraOrderParams($this->filterParams);
		}

		if($this->dataProviderOperatorsSetup->getPager() !== null) {
			$this->paginator = $this->dataProviderOperatorsSetup->getPager()->getPaginator(
				$this->nbAll, array_merge($this->filterParams, $orderParams)
			);
		}
	}

	/**
	 * @return bool
	 */
	public function hasOrder(): bool
	{
		return $this->hasOrder;
	}

	/**
	 * @param string $columnName
	 * @return bool
	 */
	public function isColumnOrderable(string $columnName): bool
	{
		return $this->hasOrder && $this->dataProviderOperatorsSetup->getOrder()->isColumnOrdered($columnName);
	}

	/**
	 * @param string $columnName
	 * @return array
	 */
	public function getOrderParamsForColumn(string $columnName): array
	{
		if(!$this->hasOrder) return [];
		return $this->dataProviderOperatorsSetup->getOrder()->getColumnOrderParams($columnName);
	}

	/**
	 * @param string $columnName
	 * @return null|string
	 */
	public function getColumnOrder(string $columnName)
	{
		if(!$this->hasOrder) return null;
		return $this->dataProviderOperatorsSetup->getOrder()->getColumnCurrentOrderDirection($columnName);
	}

	/**
	 * @return bool
	 */
	public function hasPaginator(): bool
	{
		return $this->hasPaginator;
	}

	/**
	 * @return PaginatorInterface
	 */
	public function getPaginator(): PaginatorInterface
	{
		return $this->paginator;
	}

	/**
	 * @return array
	 */
	public function getFilterParams(): array
	{
		return $this->filterParams;
	}

	/**
	 * @return array
	 */
	public function getResults(): array
	{
		return $this->results;
	}

	/**
	 * @return int
	 */
	public function getNbAll(): int
	{
		return $this->nbAll;
	}
}