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
	 * @return DataProviderInterface
	 */
	public function addOperator(OperatorDefinitionInterface $operator): DataProviderInterface
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
	 * @return DataProviderInterface
	 */
	public function addFilter(FilterOperatorDefinitionInterface $filter, array $extraConfig = []): DataProviderInterface
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
	 * @return DataProviderInterface
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
	 * @return DataProviderInterface
	 */
	public function setPager(PagerOperatorDefinitionInterface $pager): DataProviderInterface
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
}