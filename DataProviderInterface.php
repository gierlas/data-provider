<?php

namespace Kora\DataProvider;

use Kora\DataProvider\OperatorDefinition\FilterOperatorDefinitionInterface;
use Kora\DataProvider\OperatorDefinition\OrderOperatorDefinitionInterface;
use Kora\DataProvider\OperatorDefinition\PagerOperatorDefinitionInterface;


/**
 * Interface DataProviderInterface
 * @author Paweł Gierlasiński <gierlasinski.pawel@gmail.com>
 */
interface DataProviderInterface
{
	/**
	 * @param OperatorDefinitionInterface $operator
	 * @return DataProviderInterface
	 */
	public function addOperator(OperatorDefinitionInterface $operator): DataProviderInterface;

	/**
	 * @return OperatorDefinitionInterface[]
	 */
	public function getOperators(): array;

	/**
	 * @param FilterOperatorDefinitionInterface $filter
	 * @param array                             $extraConfig
	 * @return DataProviderInterface
	 */
	public function addFilter(FilterOperatorDefinitionInterface $filter, array $extraConfig = []): DataProviderInterface;

	/**
	 * @return FilterOperatorDefinitionInterface[]
	 */
	public function getFilters(): array;

	/**
	 * @return \Generator|array[]
	 */
	public function getFiltersWithExtraConfigIterator();

	/**
	 * @param OrderOperatorDefinitionInterface $order
	 * @return DataProviderInterface
	 */
	public function setOrder(OrderOperatorDefinitionInterface $order);

	/**
	 * @return OrderOperatorDefinitionInterface
	 */
	public function getOrder();

	/**
	 * @param PagerOperatorDefinitionInterface $pager
	 * @return DataProviderInterface
	 */
	public function setPager(PagerOperatorDefinitionInterface $pager): DataProviderInterface;

	/**
	 * @return PagerOperatorDefinitionInterface
	 */
	public function getPager();

	/**
	 * @return int
	 */
	public function count(): int;

	/**
	 * @return array
	 */
	public function fetchData(): array;
}