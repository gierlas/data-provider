<?php

namespace Kora\DataProvider;

use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;
use Kora\DataProvider\OperatorDefinition\OrderOperatorDefinitionInterface;
use Kora\DataProvider\OperatorDefinition\PagerOperatorDefinitionInterface;


/**
 * Class DataProviderOperatorsSetup
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
class DataProviderOperatorsSetup
{
	/**
	 * @var OperatorDefinitionInterface[]
	 */
	protected $operators = [];

	/**
	 * @var FilterOperatorDefinitionInterface[]
	 */
	protected $filters = [];

	/**
	 * @var array[]
	 */
	protected $filtersExtraConfig = [];

	/**
	 * @var OrderOperatorDefinitionInterface
	 */
	protected $order;

	/**
	 * @var PagerOperatorDefinitionInterface
	 */
	protected $pager;

	/**
	 * @param OperatorDefinitionInterface $operator
	 *
	 * @return DataProviderOperatorsSetup
	 */
	public function addOperator(OperatorDefinitionInterface $operator): DataProviderOperatorsSetup
	{
		$this->operators[] = $operator;
		return $this;
	}

	/**
	 * @return OperatorDefinitionInterface[]
	 */
	public function getOperators(): array
	{
		return $this->operators;
	}

	/**
	 * @param FilterOperatorDefinitionInterface $filter
	 *
	 * @param array                             $extraConfig
	 * @return DataProviderOperatorsSetup
	 */
	public function addFilter(FilterOperatorDefinitionInterface $filter, array $extraConfig = []): DataProviderOperatorsSetup
	{
		$this->filters[$filter->getName()] = $filter;
		$this->filtersExtraConfig[$filter->getName()] = $extraConfig;
		$this->addOperator($filter);

		return $this;
	}

	/**
	 * @return FilterOperatorDefinitionInterface[]
	 */
	public function getFilters(): array
	{
		return $this->filters;
	}

	/**
	 * @return \Generator|array[]
	 */
	public function getFiltersWithExtraConfigIterator()
	{
		foreach ($this->filters as $filter) {
			yield $filter->getName() => [$filter, $this->filtersExtraConfig[$filter->getName()]];
		}
	}

	/**
	 * @param OrderOperatorDefinitionInterface $order
	 * @return DataProviderOperatorsSetup
	 */
	public function setOrder(OrderOperatorDefinitionInterface $order)
	{
		$this->order = $order;
		$this->addOperator($order);

		return $this;
	}

	/**
	 * @return OrderOperatorDefinitionInterface
	 */
	public function getOrder()
	{
		return $this->order;
	}

	/**
	 * @param PagerOperatorDefinitionInterface $pager
	 * @return DataProviderOperatorsSetup
	 */
	public function setPager(PagerOperatorDefinitionInterface $pager): DataProviderOperatorsSetup
	{
		$this->pager = $pager;
		$this->addOperator($pager);

		return $this;
	}

	/**
	 * @return PagerOperatorDefinitionInterface
	 */
	public function getPager()
	{
		return $this->pager;
	}

	/**
	 * @param array $params
	 */
	public function setData(array $params)
	{
		foreach ($this->operators as $operator) {
			$operator->initData($params);
		}
	}
}