<?php

namespace Kora\DataProvider;

use Kora\DataProvider\OperatorDefinition\PaginatorInterface;


/**
 * Class Result
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class Result
{
	/**
	 * @var DataProviderInterface
	 */
	private $dataProvider;

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
	 * @param DataProviderInterface $dataProvider
	 * @param array                 $results
	 * @param int                   $nbAll
	 */
	public function __construct(DataProviderInterface $dataProvider, array $results, int $nbAll)
	{
		$this->dataProvider = $dataProvider;
		$this->results = $results;
		$this->nbAll = $nbAll;

		$this->hasOrder = $this->dataProvider->getOrder() !== null;
		$this->hasPaginator = $this->dataProvider->getPager() !== null;

		$this->init();
	}

	protected function init()
	{
		foreach ($this->dataProvider->getFilters() as $filter) {
			$value = $filter->getParamValue();
			if(empty($value)) continue;
			$this->filterParams += $value;
		}

		$orderParams = [];
		if($this->dataProvider->getOrder() !== null) {
			$orderParams = $this->dataProvider->getOrder()->getParamValue();
			$this->dataProvider->getOrder()->setExtraOrderParams($this->filterParams);
		}

		if($this->dataProvider->getPager() !== null) {
			$this->paginator = $this->dataProvider->getPager()->getPaginator(
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
		return $this->hasOrder && $this->dataProvider->getOrder()->isColumnOrdered($columnName);
	}

	/**
	 * @param string $columnName
	 * @return array
	 */
	public function getOrderParamsForColumn(string $columnName): array
	{
		if(!$this->hasOrder) return [];
		return $this->dataProvider->getOrder()->getColumnOrderParams($columnName);
	}

	/**
	 * @param string $columnName
	 * @return null|string
	 */
	public function getColumnOrder(string $columnName)
	{
		if(!$this->hasOrder) return null;
		return $this->dataProvider->getOrder()->getColumnCurrentOrderDirection($columnName);
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
}